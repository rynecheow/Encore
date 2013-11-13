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
     * @Route("/events/{eventId}/purchase", name="encore_purchase")
     * @ParamConverter("event", class="EncoreCustomerBundle:Event", options={"id" = "eventId"})
     */
    public function purchaseAction(Event $event)
    {
        $request = $this->getRequest();
        if($request->getMethod() === "POST"){

        }else{
            $eventHolders = $event->getEventHolders();
            $heldDates = [];
            foreach ($eventHolders as $eventHolder) {
                $heldDates[] = $eventHolder->getHeldDate()->format("Y-m-d");
            }
            sort($heldDates);
            $heldDates = array_unique($heldDates);

            $params = [
                "event_id" => $event->getId(),
                "event_name" => $event->getName(),
                "dateArray" => $heldDates
            ];

            return $this->render("EncoreCustomerBundle:Events:seat-selection.html.twig", $params);
        }


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

    /* ------- ------- ------- Private Methods ------- ------- -------*/

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

    private function getEventSections($id, $selectedDateTime)
    {
        $status = 'success';
        $msg = 'OK';
        /**
         * @var $eventRepo \Encore\CustomerBundle\Repository\EventHolderRepository
         */
        $eventRepo = $this->em->getRepository('EncoreCustomerBundle:EventHolder');
        $eventSections = $eventRepo->findAllEventVenueSectionsByEventIdAndEventDateTime($id, $selectedDateTime);
        $times = [];
        if (!count($eventSections)) {
            $status = 'error';
            $msg = 'There isn\'t any time available for this event';
        }

        $result = [
            'status' => $status,
            'message' => $msg,
            'event_sections' => $eventSections
        ];

        return $result;
    }

    /* ------- ------- ------- AJAX ------- ------- -------*/

    /**
     * @Route("/select_section", name="encore_select_section")
     * @Method("POST")
     */
    public function selectSectionAction()
    {

    }

    /**
     * @Route("/select_time", name="encore_select_time")
     * @Method("POST")
     */
    public function selectTimeAction()
    {
        $id = $this->getRequest()->get('id');
        $selectedDateTime = $this->getRequest()->get('datetime');
        if (isset($id) && isset($selectedDateTime)) {
            $result = $this->getEventSections($id, $selectedDateTime);
        }

        if ($result) {
            $response = [
                "code" => $result["status"] === "error" ? 400 : 200,
                "status" => $result["status"] === "error" ? false : true,
                "event_sections" => $result["event_sections"]
            ];
        }

        return new Response(json_encode($response));
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
}