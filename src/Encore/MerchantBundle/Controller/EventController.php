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
    public function addAction()
    {
        $params = []; //TODO Get this param
        $newEvent = new Event();
        $newEvent->setName($params["event_name"])
            ->setType($params["event_type"])
            ->setDescription($params["event_description"])
            ->setSaleStart($params["event_sale_start"])
            ->setSaleEnd($params["event_sale_end"])
            ->setHeldDates($params["event_held_dates"])
            ->setTotalTickets($params["event_total_tickets"]);
//        $newEvent->set

        return $this->render("EncoreMerchantBundle::Events:add-event.html.twig");
    }

    /**
     * @Route("/event/{id}/edit", name="encore_merchant_edit_event")
     */
    public function editAction()
    {
        return $this->render("EncoreMerchantBundle::Events:add-event.html.twig");
    }
} 