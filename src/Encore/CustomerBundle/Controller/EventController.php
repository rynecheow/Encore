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
     * @Route("/events/{id}", name="encore_event_details")
     * @ParamConverter("event")
     */
    public function eventDetailAction($id)
    {
        /**
         * @var $event \Encore\CustomerBundle\Entity\Event
         */
        $event = $this->em
            ->getRepository("EncoreCustomerBundle:Event")
            ->find($id);

        if (!$event) {
            throw $this->createNotFoundException("No event found for id " . $id . " WHYYYYY!");
        }

        $heldDates = $event->getHeldDates();
        $heldDates = $heldDates->format("Y-m-d H:i");
        $venue = $event->getVenue();

        if (!$venue) {
            throw $this->createNotFoundException("No venue found for id " . $venue->getId() . " WHYYYYY!");
        }

        $merchant = $event->getCreator();

        if (!$venue) {
            throw $this->createNotFoundException("No merchant found for id " . $merchant->getId() . " WHYYYYY!");
        }

        $photos = $event->getPhotos();
        $photoSequence = $event->getPhotoSequence();
        $photoPath = [];
        $photosNumber = count($photos);

        foreach ($photoSequence as $photoId) {
            for ($i=0; $i<$photosNumber; $i++)
            {
                if ($photoId == $photos[$i]->getId()) {
                    $photoPath[] = $photos[$i]->getImagePath();
                }
            }
        }

        $params = [
            "event_id" => $event->getId(),
            "event_name" => $event->getName(),
            "event_type" => $event->getType(),
            "event_description" => $event->getDescription(),
            "event_created_at" => $event->getCreateAt(),
            "event_sale_start" => $event->getSaleStart(),
            "event_sale_end" => $event->getSaleEnd(),
            "event_held_dates" => $heldDates,
            "event_total_tickets" => $event->getTotalTickets(),
			"event_photos" =>$photoPath,
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