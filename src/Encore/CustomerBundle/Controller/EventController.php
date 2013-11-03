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
    public function detailAction($id)
    {
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
            "EVENT_NAME" => $event->getName(),
            "EVENT_TYPE" => $event->getType(),
            "EVENT_DESC" => $event->getDescription(),
            "EVENT_CREATE_AT" => $event->getCreateAt(),
            "EVENT_SALE_START" => $event->getSaleStart(),
            "EVENT_SALE_END" => $event->getSaleEnd(),
            "EVENT_HELD_DATES" => $heldDates,
            "EVENT_TOTAL_TICKET" => $event->getTotalTickets(),
            "EVENT_PHOTOS" =>$photoPath,
            "VENUE_NAME" => $venue->getName(),
            "VENUE_LOCATE" => $venue->getLocation()
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