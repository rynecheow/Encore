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


class EventController extends Controller
{
    use ControllerHelperTrait;

    private $createform;
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
        $this->createform = $createEventForm;

        if ($createEventForm->isValid()) {
            /**
             * @var $selectedVenue \Encore\CustomerBundle\Entity\Venue
             */
            $selectedVenueId = $createEventForm->get("venue")->getData();
            $selectedVenue = $this->em->getRepository("EncoreCustomerBundle:Venue")
                ->find($selectedVenueId);
            $newEvent->setVenue($selectedVenue)
                ->setPublish(false);
            $this->em->persist($newEvent);
            $this->em->flush();
            $heldDates = $createEventForm->get("heldDates")->getData();

            foreach ($heldDates as $heldDate) {
                $eventHolder = new EventHolder();
                $eventHolder->setHeldDate($heldDate)
                    ->setEvent($newEvent);
                $this->em->persist($eventHolder);
                $this->em->flush();

                $sections = $newEvent->getVenue()->getSections();

                /**
                 * @var $section \Encore\CustomerBundle\Entity\Section
                 */
                foreach ($sections as $section) {
                    $seats = $section->getSeats();
                    $eventSectionPrice = $createEventForm->get($section->getName())->getData();
                    $eventSection = new EventSection();
                    $eventSection->setEventHolder($eventHolder)
                        ->setSection($section)
                        ->setPrice($eventSectionPrice)
                        ->setTotalSeats(count($seats))
                        ->setTotalSold(0);
                    $this->em->persist($eventSection);
                    $this->em->flush();

//                foreach ($seats as $seat)
//                {
//                    $eventSeat = new EventSeat();
//                    $eventSeat->setSeat($seat)
//                              ->setStatus(0)
//                              ->setEventSection($eventSection);
//                    $this->em->persist($eventSeat);
//                    $this->em->flush();
//                }
                }
            }

            return $this->render("EncoreMerchantBundle:Events:index.html.twig");
        }

        return $this->render("EncoreMerchantBundle:Events:add-event.html.twig" , [
                "form" => $createEventForm->createView()
            ]) ;
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

        if ($editEventForm->isValid()) {
            $params = $editEventForm->getData();
            $event->setName($params["event_name"])
                ->setDescription($params["event_description"]);

            if (!$event->getPublish()) {
                $event->setType($params["event_type"])
                    ->setSaleStart($params["event_sale_start"])
                    ->setSaleEnd($params["event_sale_end"]);

                $selectedVenueId = $editEventForm->get("venue")->getData();

                if ($selectedVenueId != $event->getVenue()->getId()) {
                    /**
                     * @var $selectedVenue \Encore\CustomerBundle\Entity\Venue
                     */
                    $selectedVenue = $this->em->getRepository("EncoreCustomerBundle:Venue")
                        ->find($selectedVenueId);
                    $event->setVenue($selectedVenue);
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

                $heldDates = $editEventForm->get("heldDates")->getData();
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
                            $eventSectionPrice = $editEventForm->get($section->getName())->getData();
                            $eventSection = new EventSection();
                            $eventSection->setEventHolder($eventHolder)
                                ->setSection($section)
                                ->setPrice($eventSectionPrice)
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

                        if (!exist) {
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
                                $eventSectionPrice = $editEventForm->get($section->getName())->getData();
                                $eventSection = new EventSection();
                                $eventSection->setEventHolder($eventHolder)
                                    ->setSection($section)
                                    ->setPrice($eventSectionPrice)
                                    ->setTotalSeats(count($seats))
                                    ->setTotalSold(0);
                                $this->em->persist($eventSection);
                                $this->em->flush();
                            }
                        }
                    }
                }
            }

            return $this->render("EncoreMerchantBundle:Events:index.html.twig");
        }

        return $this->render("EncoreMerchantBundle:Events:edit-event.html.twig");
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

        $response = [
            "code" => "200",
            "status" => true,
            "venues" => $venuesInfo
        ];
//TODO Response for array 0

        $this->createVenue();
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

    private function createVenue() {
        $this->createform->add('task', 'text');

    }

    public function removeHeldDate()
    {
        $request = $this->getRequest("request");
        $eventId = $request->query->get("eventId");
        $heldDate = $request->query->get("heldDate");
        $eventHolder = $this->em->getRepository("EncoreCustomerBundle:EventHolder")
            ->findAllEventHolderByEventIdAndHeldDate($eventId, $heldDate);

        if (count($eventHolder) != 0) {
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
        } else {
            $response = [
                "code" => "400",
                "status" => false,
                "message" => "Held date not found."
            ];
        }

        return new Response(json_encode($response));
    }

    private function createEventForm(Event $event, $allVenueLocation)
    {


        return $this->createFormBuilder()
            ->setAction('encore_merchant_add_event')
            ->add(
                'event_name',
                'text',
                [
                    'attr' => [
                        'class' => 'merchant-add-textbox',
                        'placeholder' => 'Event Name',
                        'data-required' => 'true',
                        'data-trigger' => 'change',
                        'data-required-message' => 'Please enter your event name.',
                    ]
                    ,
                    'label' => 'Event Name'
                    ,
                    'label_attr' => [
                        'class' => 'class-label'
                    ]
                ]
            )
            ->add(
                'event_type',
                'text',
                [
                    'attr' => [
                        'class' => 'merchant-add-textbox',
                        'placeholder' => 'Event Type',
                        'data-required' => 'true',
                        'data-trigger' => 'change',
                        'data-required-message' => 'Please enter your event type.',
                    ]
                    ,
                    'label' => 'Event Type'
                    ,
                    'label_attr' => [
                        'class' => 'class-label'
                    ]
                ]
            )
            ->add(
                'event_description',
                'textarea',
                [
                    'attr' => [
                        'class' => 'merchant-add-textarea',
                        'placeholder' => 'Event Description',
                        'data-required' => 'true',
                        'data-trigger' => 'keyup',
                        'data-required-message' => 'Please enter your event description.',
                        'data-rangelength' => '[20,200]',

                    ]
                    ,
                    'label' => 'Event Description'
                    ,
                    'label_attr' => [
                        'class' => 'class-label'
                    ]
                ]
            )
            ->add(
                'event_sale_start',
                'text',
                [
                    'attr' => [
                        'class' => 'merchant-add-text datepicker',
                        'placeholder' => 'Event Start Date',
                        'data-required' => 'true',
                        'data-trigger' => 'change',
                        'data-required-message' => 'Please enter your event start date.',
                    ]
                    ,
                    'label' => 'Event Sale Start'
                    ,
                    'label_attr' => [
                        'class' => 'class-label'
                    ]
                ]
            )
            ->add(
                'event_sale_end',
                'text',
                [
                    'attr' => [
                        'class' => 'merchant-add-text datepicker',
                        'placeholder' => 'Event End Date',
                        'data-required' => 'true',
                        'data-trigger' => 'change',
                        'data-required-message' => 'Please enter your event end date.',
                    ]
                    ,
                    'label' => 'Event Sale End'
                    ,
                    'label_attr' => [
                        'class' => 'class-label'
                    ]
                ]
            )
            ->add(
                'event_total_location',
                'choice',
                [
                    'choices' => $allVenueLocation
                    ,
                    'attr' => [
                        'class' => 'merchant-location',
                        'data-required' => 'true',
                        'data-trigger' => 'change',
                        'data-required-message' => 'Please select your location.',
                    ]
                    ,
                    'label' => 'Event End Date'
                    ,
                    'label_attr' => [
                        'class' => 'class-label'
                    ]
                    ,"expanded" => false,
                    "multiple" =>false
                ]

            )
            ->add(
                'register',
                'submit',
                [
                    'attr' => [
                        'class' => 'merchant-add-submit',
                        'value' => 'Register'
                    ]
                ]
            )
            ->getForm();
    }
} 