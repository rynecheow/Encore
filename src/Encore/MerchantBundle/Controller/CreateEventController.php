<?php
/**
 * Created by PhpStorm.
 * User: LiHao
 * Date: 11/7/13
 * Time: 6:20 PM
 */

namespace Encore\CustomerBundle\Controller;

use Encore\CustomerBundle\Entity\Event;
use Encore\MerchantBundle\Controller\BaseController;

class CreateEventController extends BaseController
{
    public function createEventAction($params)
    {
        $newEvent = new Event();
        $newEvent->setName($params["event_name"]);
        $newEvent->setType($params["event_type"]);
        $newEvent->setDescription($params["event_description"]);
        $newEvent->setCreateAt($params["event_created_at"]);
        $newEvent->setSaleStart($params["event_sale_start"]);
        $newEvent->setSaleEnd($params["event_sale_end"]);
        $newEvent->setHeldDates($params["event_held_dates"]);
        $newEvent->setTotalTickets($params["event_total_tickets"]);
        $newEvent->set
    }
} 