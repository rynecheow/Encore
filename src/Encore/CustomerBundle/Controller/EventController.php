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
        $eventHolders = [];

        foreach ($event->getEventHolders() as $eventHolder)
        {
            $eventHolders[] = $eventHolder->getHeldDate()->format("Y-m-d");
        }

        $eventType = "";
        switch ($event->getType())
        {
            case "1":
                $eventType = "Performing Arts";
                break;

            case "2":
                $eventType = "Concert";
                break;

            case "3":
                $eventType = "Art";
                break;

            case "4":
                $eventType = "Exhibition";
                break;

            default:
                $eventType = "Others";
                break;
        }

        return $this->render("EncoreCustomerBundle:Events:event.html.twig", [
                "event" => $event,
                "eventType" => $eventType,
                "eventHolders" => $eventHolders
            ]);
    }
} 