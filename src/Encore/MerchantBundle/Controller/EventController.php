<?php
/**
 * Created by PhpStorm.
 * User: Ryne Cheow
 * Date: 11/7/13
 * Time: 10:56 PM
 */

namespace Encore\MerchantBundle\Controller;

use Encore\CustomerBundle\Entity\EventHolder;
use Encore\CustomerBundle\Entity\EventSeat;
use Encore\CustomerBundle\Entity\EventSection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Encore\CustomerBundle\Entity\Event;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Validator\Constraints\Date;
use DateTime;


class EventController extends Controller
{
    use ControllerHelperTrait;

    /**
     * @Route("/events", name="encore_merchant_events")
     */
    public function indexAction()
    {
        return $this->render("EncoreMerchantBundle:Events:index.html.twig");
    }

    /**
     * @Route("/events/add", name="encore_merchant_add_event")
     * @Method({"GET","POST"})
     *
     */
    public function addAction()
    {
        /* Convert To Key To Key Array */
        $allVenueLocations = $this->em->getRepository("EncoreCustomerBundle:Venue")->findAllLocation();
        $array = json_decode(json_encode($allVenueLocations), true);
        $allLocations = [];

        foreach ($array as $allVenueLocation) {
            foreach ($allVenueLocation as $value) {
                $allLocations[] = [
                    $value => $value
                ];
            }
        }

        $request = $this->getRequest();

        if ($request->getMethod() === "POST") {
            $formData = $request->request->all();
            $currentDate = new \DateTime();
            $saleStart = DateTime::createFromFormat("Y-m-d", $formData["event_sale_start"]);
            $saleEnd = DateTime::createFromFormat("Y-m-d", $formData["event_sale_end"]);

            /**
             * @var $venue \Encore\CustomerBundle\Entity\Venue
             */
            $venue = $this->em->getRepository("EncoreCustomerBundle:Venue")
                ->find($formData["event_venue"]);

            if (!$venue) {
                throw $this->createNotFoundException("No venue found for id " . $venue->getId() . " WHYYYYY!");
            }

            //TODO: put back when log in done.
            //$merchant = $this->getLoggedInUser()->getMerchant();

            $merchant = $this->em->getRepository("EncoreCustomerBundle:Merchant")
                             ->find("1");

            if (!$merchant) {
                throw $this->createNotFoundException("No merchant found for id " . $merchant->getId() . " WHYYYYY!");
            }

            $newEvent = new Event();
            $newEvent->setName($formData["event_name"])
                ->setType($formData["event_type"])
                ->setDescription($formData["event_description"])
                ->setCreateAt($currentDate)
                ->setSaleStart($saleStart)
                ->setSaleEnd($saleEnd)
                ->setVenue($venue)
                ->setCreator($merchant);
            $this->em->persist($newEvent);
            $this->em->flush();

            $dates = $formData["event_held_date"];
            $times = $formData["event_held_time"];

            foreach ($dates as $index => $date)
            {
                $datetime = $date." ".$times[$index];
                $heldDate = DateTime::createFromFormat("Y-m-d G:ia", $datetime);
                $eventHolder = new EventHolder();
                $eventHolder->setEvent($newEvent)
                    ->setHeldDate($heldDate);
                $this->em->persist($eventHolder);
                $this->em->flush();

                $sections = $newEvent->getVenue()->getSections();

                /**
                 * @var $section \Encore\CustomerBundle\Entity\Section
                 */
                foreach ($sections as $section) {
                    $seats = $section->getSeats();
//                            $eventSectionPrice = $formData[];
                    $eventSection = new EventSection();
                    $eventSection->setEventHolder($eventHolder)
                        ->setSection($section)
//                                ->setPrice($eventSectionPrice)
                        ->setTotalSeats(count($seats))
                        ->setTotalSold(0);
                    $this->em->persist($eventSection);
                    $this->em->flush();
                }
            }

            return $this->redirect($this->generateUrl(
                    "encore_merchant_add_event_photo",
                    [
                        "eventId" => $newEvent->getId()
                    ]
                ));
        }

        return $this->render(
            "EncoreMerchantBundle:Events:add-event.html.twig",
            [
                "locations" => $allLocations
            ]
        );
    }

    /**
     * @Route("/event/{eventId}/edit", name="encore_merchant_edit_event")
     * @ParamConverter("event", class="EncoreCustomerBundle:Event", options={"id" = "eventId"})
     * @Method({"GET","POST"})
     */
    public function editAction(Event $event)
    {
        $venue = $event->getVenue();

        $eventInfo = [
            "id" => $event->getId(),
            "name" => $event->getName(),
            "type" => $event->getType(),
            "description" => $event->getDescription(),
            "sale_start" => $event->getSaleStart()->format("Y-m-d"),
            "sale_end" => $event->getSaleEnd()->format("Y-m-d"),
            "venue_name" => $venue->getName(),
            "venue_id" => $venue->getId(),
            "venue_location" => $venue->getLocation(),
        ];

        /* Convert To Key To Key Array */
        $allVenueLocations = $this->em->getRepository("EncoreCustomerBundle:Venue")->findAllLocation();
        $array = json_decode(json_encode($allVenueLocations), true);
        $allLocations = [];

        foreach ($array as $allVenueLocation) {
            foreach ($allVenueLocation as $value) {
                $allLocations[] = [
                    $value => $value
                ];
            }
        }

        $eventHolders = $event->getEventHolders();
        $dates = [];
        $times = [];

        foreach ($eventHolders as $eventHolder)
        {
            $datetime = $eventHolder->getHeldDate();
            $dates[] = $datetime->format("Y-m-d");
            $times[] = $datetime->format("G:ia");
        }

        $request = $this->getRequest();

        if ($request->getMethod() === "POST") {
            $formData = $request->request->all();
            $saleEnd = DateTime::createFromFormat("Y-m-d", $formData["event_sale_end"]);

            if ($event->getPublish())
            {
                $event->setSaleEnd($saleEnd)
                    ->setDescription($formData["event_description"]);
                $this->em->flush();
            }

            else
            {
                $saleStart = DateTime::createFromFormat("Y-m-d", $formData["event_sale_start"]);

                /**
                 * @var $venue \Encore\CustomerBundle\Entity\Venue
                 */
                $venue = $this->em->getRepository("EncoreCustomerBundle:Venue")
                    ->find($formData["event_venue"]);

                if (!$venue) {
                    throw $this->createNotFoundException("No venue found for id " . $venue->getId() . " WHYYYYY!");
                }

                $event->setName($formData["event_name"])
                    ->setType($formData["event_type"])
                    ->setDescription($formData["event_description"])
                    ->setSaleStart($saleStart)
                    ->setSaleEnd($saleEnd);
                $this->em->flush();

                if ($venue->getId() != $event->getVenue()->getId()) {
                    $event->setVenue($venue);
                    $this->em->flush();
                    $eventHolders = $this->em->getRepository("EncoreCustomerBundle:EventHolder")
                        ->findByEvent($event);

                    foreach ($eventHolders as $eventHolder) {
                        $eventSections = $this->em->getRepository("EncoreCustomerBundle:EventSection")
                            ->findByEventHolder($eventHolder);

                        foreach ($eventSections as $eventSection) {
                            $this->em->remove($eventSection);
                            $this->em->flush();
                        }
                    }
                }

                $dates = $formData["event_held_date"];
                $times = $formData["event_held_time"];
                $heldDates = [];

                foreach ($dates as $index => $date)
                {
                    $datetime = $date." ".$times[$index];
                    $heldDates = DateTime::createFromFormat("Y-m-d G:ia", $datetime);
                }

                $eventHolders = $this->em->getRepository("EncoreCustomerBundle:EventHolder")
                    ->findByEvent($event);


                if (count($eventHolders) === 0) {
                    foreach ($heldDates as $heldDate) {
                        $newEventHolder = new EventHolder();
                        $newEventHolder->setEvent($event)
                            ->setHeldDate($heldDate);
                        $this->em->persist($newEventHolder);
                        $this->em->flush();
                        $sections = $event->getVenue()->getSections();

                        /**
                         * @var $section \Encore\CustomerBundle\Entity\Section
                         */
                        foreach ($sections as $section) {
                            $seats = $section->getSeats();
//                            $eventSectionPrice = $formData[];
                            $eventSection = new EventSection();
                            $eventSection->setEventHolder($eventHolder)
                                ->setSection($section)
//                                ->setPrice($eventSectionPrice)
                                ->setTotalSeats(count($seats))
                                ->setTotalSold(0);
                            $this->em->persist($eventSection);
                            $this->em->flush();
                        }
                    }
                } else {
                    foreach ($heldDates as $heldDate) {
                        $exist = false;

                        /**
                         * @var $eventHolder \Encore\CustomerBundle\Entity\EventHolder
                         */
                        foreach ($eventHolders as $eventHolder) {
                            if ($heldDate === $eventHolder->getHeldDate()) {
                                $exist = true;
                            }
                        }

                        if (!$exist) {
                            $newEventHolder = new EventHolder();
                            $newEventHolder->setEvent($event)
                                ->setHeldDate($heldDate);
                            $this->em->persist($newEventHolder);
                            $this->em->flush();
                            $sections = $event->getVenue()->getSections();

                            /**
                             * @var $section \Encore\CustomerBundle\Entity\Section
                             */
                            foreach ($sections as $section) {
                                $seats = $section->getSeats();
//                                $eventSectionPrice = $formData[];
                                $eventSection = new EventSection();
                                $eventSection->setEventHolder($eventHolder)
                                    ->setSection($section)
//                                    ->setPrice($eventSectionPrice)
                                    ->setTotalSeats(count($seats))
                                    ->setTotalSold(0);
                                $this->em->persist($eventSection);
                                $this->em->flush();
                            }
                        }
                    }
                }
            }

            return $this->render(
                "EncoreMerchantBundle:Events:add-event-photo.html.twig",
                [
                    "eventId" => $event->getId()
                ]
            );
        }

        return $this->render(
            "EncoreMerchantBundle:Events:edit-event.html.twig",
            [
                "locations" => $allLocations,
                "event" => $eventInfo,
                "event_held_date" => $dates,
                "event_held_time" => $times
            ]
        );
    }

    /**
     * @Route("/venue-location", name="encore_venue_location")
     * @Method("POST")
     */
    public function getLocationVenue()
    {
        $request = $this->getRequest();
        $location = $request->get("location");
        $venues = $this->em->getRepository("EncoreCustomerBundle:Venue")
            ->findByLocation($location);
        $venuesInfo = [];

        /**
         * @var $venue \Encore\CustomerBundle\Entity\Venue
         */
        foreach ($venues as $venue) {
            $venuesInfo[] = [
                "id" => $venue->getId(),
                "name" => $venue->getName(),
            ];
        }

        if (count($venuesInfo) === 0) {
            $response = [
                "code" => "200",
                "status" => true,
                "message" => "No venue found on that location."
            ];
        } else {
            $response = [
                "code" => "200",
                "status" => true,
                "venues" => $venuesInfo,
                "message" => "Venue information has returned."
            ];
        }

        return new Response(json_encode($response));
    }

    /**
     * @Route("/venue-section", name="encore_venue_section")
     * @Method("POST")
     */
    public function getVenueSection()
    {
        $request = $this->getRequest();
        $venueId = $request->get("venueId");
        $venue = $this->em->getRepository("EncoreCustomerBundle:Venue")
            ->find($venueId);
        $sections = $venue->getSections();
        $sectionsInfo = [];

        /**
         * @var $section \Encore\CustomerBundle\Entity\Section
         */
        foreach ($sections as $section) {
            $sectionsInfo[] = [
                "id" => $section->getId(),
                "name" => $section->getName(),
                "total_seats" => count($section->getSeats())
            ];
        }

        $response = [
            "code" => "200",
            "status" => true,
            "sections" => $sectionsInfo
        ];

        return new Response(json_encode($response));
    }

    public function removeHeldDate()
    {
        $request = $this->getRequest("request");
        $eventId = $request->query->get("eventId");
        $date = $request->query->get("date");
        $time = $request->query->get("time");
        $datetime = $date." ".$time;
        $heldDate = DateTime::createFromFormat("Y-m-d G:ia", $datetime);
        $eventHolders = $this->em->getRepository("EncoreCustomerBundle:EventHolder")
            ->findAllEventHolderByEventIdAndHeldDate($eventId, $heldDate);

        if (count($eventHolders) != 0) {
            foreach ($eventHolders as $eventHolder)
            {
                $eventSections = $this->em->getRepository("EncoreCustomerBundle:EventSection")
                    ->findByEventHolder($eventHolder);

                foreach ($eventSections as $eventSection) {
                    $this->em->remove($eventSection);
                    $this->em->flush();
                }

                $this->em->remove($eventHolder);
                $this->em->flush();
                $response = [
                    "code" => "200",
                    "status" => true,
                    "message" => "Held date has successfully removed."
                ];
            }
        } else {
            $response = [
                "code" => "404",
                "status" => false,
                "message" => "Held date not found."
            ];
        }

        return new Response(json_encode($response));
    }
}
