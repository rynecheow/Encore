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

        if ($editEventForm->isValid()) {
            $params = $editEventForm->getData();
            $event->setName($params["event_name"])
                ->setType($params["event_type"])
                ->setDescription($params["event_description"])
                ->setSaleStart($params["event_sale_start"])
                ->setSaleEnd($params["event_sale_end"])
                ->setHeldDates($params["event_held_dates"]);

            if (!$event->getPublish()) {
                /**
                 * @var $selectedVenue \Encore\CustomerBundle\Entity\Venue
                 */
                $selectedVenueId = $editEventForm->get("venue")->getData();

                if ($selectedVenueId != $event->getVenue()->getId()) {
                    $selectedVenue = $this->em->getRepository("EncoreCustomerBundle:Venue")
                        ->find($selectedVenueId);
                    $event->setVenue($selectedVenue);

                    //TODO: edit held dates, remove previous eventSection.
                } else {
                    //TODO: add held dates, add eventSection.
                }
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

    private function createEventForm(Event $event, $allVenueLocation)
    {
        return $this->createFormBuilder()
            ->setAction('encore_signup')
            ->add(
                'email',
                'email',
                [
                    'attr' => [
                        'class' => 'signup-email',
                        'placeholder' => 'E-mail address',
                        'data-required' => 'true',
                        'data-trigger' => 'change',
                        'data-type' => 'email',
                        'data-required-message' => 'Please enter your email.',
                        'data-type-email-message' => 'Your email address is incorrect',
                    ]
                    ,
                    'label' => false
                ]
            )
            ->add(
                'password',
                'password',
                [
                    'attr' => [
                        'class' => 'signup-password',
                        'id' => 'sg-pw',
                        'placeholder' => 'Password',
                        'data-required' => 'true',
                        'data-trigger' => 'change',
                        'data-required-message' => 'Please enter your password.',
                        'data-minlength' => '8',
                        'data-minlength-message' => 'Short passwords are easy to guess. Try one with at least 8 characters.',
                    ],
                    'label' => false
                ]
            )
            ->add(
                'verifyPassword',
                'password',
                [
                    'attr' => [
                        'class' => 'signup-password',
                        'placeholder' => 'Verify Password',
                        'data-trigger' => 'change',
                        'data-equalto' => '#form_password',
                        'data-equalto-message' => 'You passwords do not match.',
                        'data-required' => 'true',
                        'data-required-message' => 'Please verify your password.',
                    ],
                    'label' => false
                ]
            )
            ->add(
                'agreement',
                'checkbox',
                [
                    'attr' => [
                        'id' => 'signup-agreement',
                        'class' => 'signup-agreement',
                        'placeholder' => 'Verify Password',
                        'data-trigger' => 'change',
                        'data-required' => 'true',
                        'data-required-message' => "In order to use our services, you must agree to Encore's Terms and Privacy.",
                    ],
                    'label' => false
                ]
            )
            ->add(
                'register',
                'submit',
                [
                    'attr' => [
                        'class' => 'submit',
                        'value' => 'Register'
                    ]
                ]
            )
            ->getForm();
    }
} 