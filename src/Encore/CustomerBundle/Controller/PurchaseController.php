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
            ->findByevent($id);

        $sections = $this->em
            ->getRepository("EncoreCustomerBundle:Section")
            ->findByvenue($event->getVenue());

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
        $data = [];
        return $this->render(
            "EncoreCustomerBundle:Purchase:index.html.twig",
            [
                'data' => $data
            ]
        );
    }
} 