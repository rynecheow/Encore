<?php
/**
 * Created by PhpStorm.
 * User: Ryne Cheow
 * Date: 11/7/13
 * Time: 10:56 PM
 */

namespace Encore\MerchantBundle\Controller;

use Encore\CustomerBundle\Entity\EventSeat;
use Encore\CustomerBundle\Entity\EventSection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Encore\CustomerBundle\Entity\Event;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;

class EventController extends BaseController
{

    /**
     * @Route("/events", name="encore_merchant_events")
     */
    public function indexAction()
    {
        return $this->render("EncoreMerchantBundle::Events:index.html.twig");
    }

    /**
     * @Route("/events/add", name="encore_merchant_add_event")
     */
    public function addAction(Request $request)
    {
        $allVenueLocations = $this->em->getRepository("EncoreCustomerBundle:Venue")
                                  ->findAllLocation();
        $newEvent = new Event();
        $createEventForm = $this->createEventForm($newEvent, $allVenueLocations);
        $createEventForm->handleRequest($request);

        if ($createEventForm->isValid())
        {
            /**
             * @var $selectedVenue \Encore\CustomerBundle\Entity\Venue
             */
            $selectedVenueId = $createEventForm->get("venue")->getData();
            $selectedVenue = $this->em->getRepository("EncoreCustomerBundle:Venue")
                                  ->find($selectedVenueId);
            $newEvent->setVenue($selectedVenue);
            $this->em->persist($newEvent);
            $this->em->flush();
            $this->pushFlashMessage("Success", "Event has been created");

            $sections = $newEvent->getVenue()->getSections();

            /**
             * @var $section \Encore\CustomerBundle\Entity\Section
             */
            foreach ($sections as $section)
            {
                $seats = $section->getSeats();
                $eventSectionPrice = $createEventForm->get($section->getName())->getData();
                $eventSection = new EventSection();
                $eventSection->setEvent($newEvent)
                             ->setSection($section)
                             ->setPrice($eventSectionPrice)
                             ->setTotalSeats(count($seats))
                             ->setTotalSold(0);
                $this->em->persist($eventSection);
                $this->em->flush();

                foreach ($seats as $seat)
                {
                    $eventSeat = new EventSeat();
                    $eventSeat->setSeat($seat)
                              ->setStatus(0)
                              ->setEventSection($eventSection);
                    $this->em->persist($eventSeat);
                    $this->em->flush();
                }
            }

            return $this->render("EncoreMerchantBundle::Events:index.html.twig");
        }

        return $this->render("EncoreMerchantBundle::Events:add-event.html.twig");
    }

    /**
     * @Route("/event/{id}/edit", name="encore_merchant_edit_event")
     * @ParamConverter("event", class="EncoreCustomerBundle:Event", options={"id" = "eventId"})
     * @Method({"GET","POST"})
     */
    public function editAction(Event $event)
    {
        $allVenueLocations = $this->em->getRepository("EncoreCustomerBundle:Venue")
            ->findAllLocation();
        $request = $this->getRequest();
        $editEventForm = $this->createEventForm($event, $allVenueLocations);
        $editEventForm->handleRequest($request);

        if ($editEventForm->isValid())
        {
            $params = $editEventForm->getData();
            $event->setName($params["event_name"])
                ->setType($params["event_type"])
                ->setDescription($params["event_description"])
                ->setSaleStart($params["event_sale_start"])
                ->setSaleEnd($params["event_sale_end"])
                ->setHeldDates($params["event_held_dates"])
                ->setTotalTickets($params["event_total_tickets"]);

            /**
             * @var $selectedVenue \Encore\CustomerBundle\Entity\Venue
             */
            $selectedVenueId = $editEventForm->get("venue")->getData();

            if ($selectedVenueId != $event->getVenue()->getId())
            {
                $selectedVenue = $this->em->getRepository("EncoreCustomerBundle:Venue")
                    ->find($selectedVenueId);
                $event->setVenue($selectedVenue);
            }

            return $this->render("EncoreMerchantBundle::Events:index.html.twig");
        }

        return $this->render("EncoreMerchantBundle::Events:edit-event.html.twig");
    }

    public function getLocationVenue()
    {
        $request = $this->getRequest("request");
        $location = $request->query->get("location");
        $venues = $this->em->getRepository("EncoreCustomerBundle:Venue")
                       ->findByLocation($location);
        $venuesInfo = [];

        /**
         * @var $venue \Encore\CustomerBundle\Entity\Venue
         */
        foreach ($venues as $venue)
        {
            $venuesInfo[] = [
                "id" => $venue->getId(),
                "name" => $venue->getName(),
            ];
        }

        $response = [
            "code" => "200",
            "status" => true,
            "venues" => $venuesInfo
        ];

        return new Response(json_encode($response));
    }

    public function getVenueSection()
    {
        $request = $this->getRequest("request");
        $venueId = $request->query->get("venueId");
        $venue = $this->em->getRepository("EncoreCustomerBundle:Venue")
                      ->find($venueId);
        $sections = $venue->getSections();
        $sectionsInfo = [];

        /**
         * @var $section \Encore\CustomerBundle\Entity\Section
         */
        foreach ($sections as $section)
        {
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

    private function createEventForm(Event $event, $allVenueLocation)
    {
        // TODO: create form for event.
    }
} 