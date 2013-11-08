<?php

namespace Encore\CustomerBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Encore\CustomerBundle\Entity\Event;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

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
     * @Route("/events/{eventId}", name="encore_event_details")
     * @ParamConverter("event", class="EncoreCustomerBundle:Event", options={"id" = "eventId"})
     */
    public function eventDetailAction(Event $event)
    {
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
            for ($i = 0; $i < $photosNumber; $i++) {
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
            "event_photos" => $photoPath,
            "venue_name" => $venue->getName(),
            "venue_location" => $venue->getLocation()
        ];

        return $this->render("EncoreCustomerBundle:Events:event.html.twig", $params);
    }
} 