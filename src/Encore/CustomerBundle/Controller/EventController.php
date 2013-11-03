<?php

namespace Encore\CustomerBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Encore\CustomerBundle\Entity\Event;

class EventController extends BaseController
{

    /**
     * @Route("/events", name="encore_events")
     *
     */
    public function indexAction()
    {
        //TODO: Show events listings
    }

    /**
     * @Route("/events/{id}", name="encore_event_details", requirements={"id" = "\d+"})
     */
    public function eventDetailAction($id)
    {
        $event = $this->em
            ->getRepository("EncoreCustomerBundle:Event")
            ->findOneBy($id);

        if (!$event) {
            throw $this->createNotFoundException("No event found for id " . $id . " WHYYYYY!");
        }

        $venue = $event->getVenue();

        if (!$venue) {
            throw $this->createNotFoundException("No venue found for id " . $venue->getId() . " WHYYYYY!");
        }

        $merchant = $event->getCreator();

        if (!$venue) {
            throw $this->createNotFoundException("No merchant found for id " . $merchant->getId() . " WHYYYYY!");
        }

        $params = [
            "event_name" => $event->getName(),
            "event_type" => $event->getType(),
            "event_description" => $event->getDescription(),
            "event_created_at" => $event->getCreateAt(),
            "event_sale_start" => $event->getSaleStart(),
            "event_sale_end" => $event->getSaleEnd(),
            "event_held_dates" => $event->getHeldDates(),
            "event_total_tickets" => $event->getTotalTickets(),
            "venue_name" => $venue->getName(),
            "venue_location" => $venue->getLocation()
        ];

        return $this->render("EncoreCustomerBundle:Events:event.html.twig", $params);
    }

    /**
     * @Route("/events/{id}/purchase/", name="envore_event_ticket_purchase", requirements={"id" = "\d+"})
     */
    public function purchaseAction($id)
    {
        //TODO handle purchase event action
    }

    /**
     * @Route("/events/{id}/purchase/summary", name="envore_event_ticket_purchase", requirements={"id" = "\d+"})
     */
    public function purchaseSummaryAction($id)
    {
        //TODO handle purchase summary event action
    }
} 