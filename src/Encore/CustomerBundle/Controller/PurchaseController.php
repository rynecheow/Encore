<?php
/**
 * Created by PhpStorm.
 * User: LiHao
 * Date: 11/5/13
 * Time: 9:33 AM
 */

namespace Encore\CustomerBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Encore\CustomerBundle\Entity\Event;
use Symfony\Component\HttpFoundation\Response;

class PurchaseController extends BaseController
{

    /**
     * @Route("/events/{id}/purchase", requirements={"id" = "\d+"})
     */
    public function purchaseAction($id)
    {
        $event = $this->em
            ->getRepository("EncoreCustomerBundle:Event")
            ->find($id);
        $heldDates = $event->getHeldDates();
        $heldDates = $heldDates->format("Y-m-d H:i");

        $eventSection = $this->em
            ->getRepository("EncoreCustomerBundle:EventSection")
            ->findByEvent($id);

        $sections = $this->em
            ->getRepository("EncoreCustomerBundle:Section")
            ->findByVenue($event->getVenue());

        $totalSection = count($eventSection);
        $sectionsInfo = [];

        for ($i = 0; $i < $totalSection; $i++) {
            $price = $eventSection[$i]->getPrice();
            $totalSeats = $eventSection[$i]->getTotalSeats();
            $totalSold = $eventSection[$i]->getTotalSold();
            $seatAvailable = $totalSeats - $totalSold;
            $name = "";

            for ($j = 0; $j < $totalSection; $j++) {
                if ($eventSection[$i]->getSection()->getId() === $sections[$j]->getId()) {
                    $name = $sections[$j]->getName();
                }
            }

            $sectionsInfo[$i] = [
                "price" => $price,
                "total_seats" => $totalSeats,
                "total_sold" => $totalSold,
                "seat_available" => $seatAvailable,
                "name" => $name
            ];
        }

        $params = [
            "event_held_dates" => $heldDates,
            "sections" => $sectionsInfo
        ];

        return $this->render("EncoreCustomerBundle:Events:purchase.html.twig", $params);
    }

    /**
     * @Route("/thank-you", name="encore_thank_you")
     *
     */
    public function thankYouAction(Request $request)
    {
        $data = []; //Todo return a ticket data
        return $this->render(
            "EncoreCustomerBundle:Purchase:index.html.twig",
            [
                'data' => $data
            ]
        );
    }

    /**
     * @Route("/events/{eventId}/purchase/seat-selection", name="encore_seat_selection")
     * @ParamConverter("event", class="EncoreCustomerBundle:Event", options={"id" = "eventId"})
     */
    public function selectSeatAction(Event $event)
    {
        $eventHolders = $event->getEventHolders();
        $heldDates = [];
        foreach ($eventHolders as $eventHolder) {
            $heldDates[] = $eventHolder->getHeldDate()->format("Y-m-d");
        }

        sort($heldDates);

        $params = [
            "event_id" => $event->getId(),
            "event_name" => $event->getName(),
            "dateArray" => $heldDates
        ];

        return $this->render("EncoreCustomerBundle:Events:seat-selection.html.twig", $params);
    }

    /**
     * @Route("/select_date", name="encore_select_date")
     * @Method("POST")
     */
    public function selectDateAction()
    {

        $id = $this->getRequest()->get('id');
        $selectedDate = $this->getRequest()->get('date');
        if (isset($id) && isset($selectedDate)) {
            $result = $this->getEventHeldTime($id, $selectedDate);
        }

        if ($result) {
            $response = [
                "code" => $result["status"] === "error" ? 400 : 200,
                "status" => $result["status"] === "error" ? false : true,
                "event_times" => $result["event_times"]
            ];
        }
        
        return new Response(json_encode($response));
    }

    private function getEventHeldTime($id, $selectedDate)
    {
        $status = 'success';
        $msg = 'OK';
        /**
         * @var $eventRepo \Encore\CustomerBundle\Repository\EventHolderRepository
         */
        $eventRepo = $this->em->getRepository('EncoreCustomerBundle:EventHolder');
        $eventTimes = $eventRepo->findAllEventTimeByEventId($id);
        $times = [];
        if (!count($eventTimes)) {
            $status = 'error';
            $msg = 'There isn\'t any time available for this event';
        } else {
            foreach ($eventTimes as $time) {
                $time = $time['heldDate']->format("Y-m-d H:i:s");
                if (strpos($time, $selectedDate) !== false) {
                    $str = date("H:i", strtotime($time));
                    $times[] = $str;
                }
            }
        }

        $result = [
            'status' => $status,
            'message' => $msg,
            'event_times' => $times
        ];

        return $result;
    }
}