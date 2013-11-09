<?php
/**
 * Created by PhpStorm.
 * User: Ryne Cheow
 * Date: 11/7/13
 * Time: 10:56 PM
 */

namespace Encore\MerchantBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Encore\CustomerBundle\Entity\Event;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

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
        $venuesInfo = $this->getAllVenueInfo();
        $newEvent = new Event();
        $createEventForm = $this->createEventForm($newEvent, $venuesInfo, $allVenueLocations);
        $createEventForm->handleRequest($request);

        if ($createEventForm->isValid())
        {
            $this->em->persist($newEvent);
            $this->em->flush();
            $this->pushFlashMessage("Success", "Event has been created");

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
        $venuesInfo = $this->getAllVenueInfo();
        $request = $this->getRequest();
        $editEventForm = $this->createEventForm($event, $venuesInfo, $allVenueLocations);
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
                ->setTotalTickets($params["event_total_tickets"])
                ->setVenue($params["event_venue"]);

            return $this->render("EncoreMerchantBundle::Events:index.html.twig");
        }

        return $this->render("EncoreMerchantBundle::Events:edit-event.html.twig");
    }

    private function getAllVenueInfo()
    {
        $allVenue = $this->em->getRepository("EncoreCustomerBundle:Venue")
            ->findAll();
        $venuesInfo = [];
        $i = 0;

        /**
         * @var $venue \Encore\CustomerBundle\Entity\Venue
         */
        foreach ($allVenue as $venue)
        {
            $sections = $this->em->getRepository("EncoreCustomerBundle:Section")
                ->findByVenue($venue);
            $sectionsInfo = [];
            $j = 0;

            /**
             * @var $section \Encore\CustomerBundle\Entity\Section
             */
            foreach ($sections as $section)
            {
                $sectionsInfo[$j] = [
                    "id" => $section->getId(),
                    "name" => $section->getName()
                ];
            }

            $venuesInfo[$i] = [
                "id" => $venue->getId(),
                "name" => $venue->getName(),
                "location" => $venue->getLocation(),
                "sections" => $sectionsInfo
            ];
        }

        return $venuesInfo;
    }

    private function createEventForm(Event $event, $venues, $allVenueLocation)
    {
        // TODO: create form for event.
    }
} 