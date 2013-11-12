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
        $params = [
            "event_name" => "This Event",
            "dateArray" => ["11/12/2013", "11/13/2013", "11/15/2013", "11/17/2013"],
            "timeArray" => ["8:00", "12:00", "14:00", "16:00", "18:00"],
            "sectionArray" => ["VVIP", "VIP", "Premium", "Standard"],
            "availableSeats" => 10,
            "rowArray" => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
            "totalCol" => 70
        ];

        return $this->render("EncoreCustomerBundle:Events:seat-selection.html.twig", $params);
    }
}