<?php
/**
 * Created by PhpStorm.
 * User: LiHao
 * Date: 10/31/13
 * Time: 4:11 PM
 */

namespace Encore\CustomerBundle\Controller;


class EventController extends BaseController
{
    public function showAction($id)
    {
        $event = $this->em
                 ->getRepository("EncoreCustomerBundle:Event")
                 ->find($id);

        if (!$event)
        {
            throw $this->createNotFoundException("No event found for id ".$id." WHYYYYY!");
        }

        $venue = $event->getVenue();

        if (!$venue)
        {
            throw $this->createNotFoundException("No venue found for id ".$venue->getId()." WHYYYYY!");
        }

        $merchant = $event->getCreator();

        if (!$venue)
        {
            throw $this->createNotFoundException("No merchant found for id ".$merchant->getId()." WHYYYYY!");
        }

        $params = [
            "EVENT_NAME" => $event->getName(),
            "EVENT_TYPE" => $event->getType(),
            "EVENT_DESC" => $event->getDescription(),
            "EVENT_CREATE_AT" => $event->getCreateAt(),
            "EVENT_SALE_START" => $event->getSaleStart(),
            "EVENT_SALE_END" => $event->getSaleEnd(),
            "EVENT_HELD_DATES" => $event->getHeldDates(),
            "EVENT_TOTAL_TICKET" => $event->getTotalTickets(),
            "VENUE_NAME" => $venue->getName(),
            "VENUE_LOCATE" => $venue->getLocation()
        ];

        return $this->render("EncoreCustomerBundle:Events:event.html.twig", $params);
    }
} 