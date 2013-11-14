<?php
/**
 * Created by PhpStorm.
 * User: LiHao
 * Date: 11/5/13
 * Time: 9:33 AM
 */
namespace Encore\CustomerBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
        if ($request->getMethod() === "POST") {
//            $formData =$request->request->all();
//            $formData = serialize($formData);
//            $url = $this->container->get('router')->generate("encore_summary");
//            $newResponse = new RedirectResponse($url);
//
//            $newResponse->setContent(json_encode($formData));
//            $newResponse->headers->set('Content-Type', 'application/json');
////            $newResponse->setTargetUrl($url);
//            return $newResponse;
        } else {
            $eventHolders = $event->getEventHolders();
            $dateArray = [];
            foreach ($eventHolders as $eventHolder) {
                $heldDate_Date = $eventHolder->getHeldDate()->format("Y-m-d");
                $heldDate_Time = $this->getEventHeldTime($event->getId(), $heldDate_Date);
                $str = date("Y-M-d", strtotime($heldDate_Date));
                $dateArray[] = [$str => $heldDate_Time];
            }
            sort($dateArray);
//            $dateArray = array_unique($dateArray);
            $params = [
                "event_id" => $event->getId(),
                "event_name" => $event->getName(),
                "dateArray" => $dateArray,
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
        /**
         * @var $eventRepo \Encore\CustomerBundle\Repository\EventHolderRepository
         */
        $eventRepo = $this->em->getRepository('EncoreCustomerBundle:EventHolder');
        $eventTimes = $eventRepo->findAllEventTimeByEventId($id);
        $times = [];
        if (count($eventTimes)) {
            foreach ($eventTimes as $time) {
                $time = $time['heldDate']->format("Y-m-d H:i:s");
                if (strpos($time, $selectedDate) !== false) {
                    $str = date("H:i", strtotime($time));
                    $times[] = $str;
                }
            }
        }
        return $times;
    }
    private function getEventSections($id, $selectedDateTime)
    {
        $status = 'success';
        $msg = 'OK';
        /**
         * @var $eventRepo \Encore\CustomerBundle\Repository\EventHolderRepository
         */
        $eventRepo = $this->em->getRepository('EncoreCustomerBundle:EventHolder');
        $eventHolders = $eventRepo->findEventHolderIdByEventIdAndEventDateTime($id, $selectedDateTime);
        $eventHolder = $eventHolders[0];
        $eventSections = $eventRepo->findAllEventVenueSectionsByEventHolderId($eventHolder);
        $sectionIDAndNames = [];
        foreach($eventSections as $eventSection)
        {
            $section = $eventSection->getSection();
            $eventSectionID = $eventSection->getId();
            $sectionIDAndNames[] = [
                "id" => $eventSectionID,
                "name" => $section->getName(),
            ];
        }
        if (!count($sectionIDAndNames)) {
            $status = 'error';
            $msg = 'There isn\'t any sections available for this event';
        }
        $result = [
            'status' => $status,
            'message' => $msg,
            'event_sections' => $sectionIDAndNames
        ];
        return $result;
    }
    private function getSectionSeats($eventSectionId)
    {
        $status = 'success';
        $msg = 'OK';
        /**
         * @var $eventRepo \Encore\CustomerBundle\Repository\EventHolderRepository
         */
        $eventRepo = $this->em->getRepository('EncoreCustomerBundle:EventHolder');
        $eventSection = $eventRepo->findEventSectionByEventSectionId($eventSectionId);
        $sectionSeats = $eventRepo->findSeatsByEventSection($eventSection);
        $section = $eventSection[0]->getSection();
        $noOfRow = $eventRepo->findNoOfRowsBySection($section);
        $noOfCol = $eventRepo->findNoOfColsBySection($section);
        $totalSeats = $eventSection[0]->getTotalSeats();
        $totalSold = $eventSection[0]->getTotalSold();
        $availableSeatsLeft = $totalSeats - $totalSold;
        if($availableSeatsLeft > 8)
        {
            $availableSeatsLeft = 8;
        }
        $seats = [];
        foreach($sectionSeats as $sectionSeat)
        {
            $status = $sectionSeat->getStatus();
            $seat = $sectionSeat->getSeat();
            $seats[] = [
                "seat" => $seat->getSeatName(),
                "row" => $seat->getRow(),
                "col" => $seat->getCol(),
                "status" => $status
            ];
        }
        $result = [
            'status' => $status,
            'message' => $msg,
            'event_max_ticket_qty' => $availableSeatsLeft,
            "no_of_rows" => count($noOfRow[0]),
            "no_of_cols" => count($noOfCol[0]),
            'event_section_seats' => $seats
        ];
        return $result;
    }
    /* ------- ------- ------- AJAX ------- ------- -------*/
    /**
     * @Route("/purchase_tickets", name="encore_purchase_tickets")
     * @Method("POST")
     */
//    public function purchaseTicketsAction()
//    {
//        $eventId = $this->getRequest()->get('id');
//        $eventName = $this->getRequest()->get('name');
//        $dateTime = $this->getRequest()->get('datetime');
//        $section = $this->getRequest()->get('section');
//        $ticketQty = $this->getRequest()->get('ticketQty');
//        $seats = $this->getRequest()->get('seats');
//        if (isset($eventId) && isset($eventName)
//            && isset($dateTime) && isset($section)
//            && isset($ticketQty) && isset($seats)
//        ) {
//            $result = [$eventId,$eventName,$dateTime,$section,$ticketQty,$seats];
//        }
//
//        if ($result) {
//            $response = [
//                "code" => $result["status"] === "error" ? 400 : 200,
//                "status" => $result["status"] === "error" ? false : true,
//            ];
//        }
//
//        return new Response(json_encode($response));
//    }
    /**
     * @Route("/select_section", name="encore_select_section")
     * @Method("POST")
     */
    public function selectSectionAction()
    {
        $eventSectionId = $this->getRequest()->get('eventSectionId');
        if (isset($eventSectionId)) {
            $result = $this->getSectionSeats($eventSectionId);
        }
        if ($result) {
            $response = [
                "code" => $result["status"] === "error" ? 400 : 200,
                "status" => $result["status"] === "error" ? false : true,
                "event_max_ticket_qty" => $result["event_max_ticket_qty"],
                "no_of_rows" => $result["no_of_rows"],
                "no_of_cols" => $result["no_of_cols"],
                "event_section_seats" => $result["event_section_seats"]
            ];
        }
        return new Response(json_encode($response));
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
            $heldDate = date("Y-m-d H:i:s", strtotime($selectedDateTime));
            $result = $this->getEventSections($id, $heldDate);
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
}