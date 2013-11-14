<?php
/**
 * Created by PhpStorm.
 * User: sysadm
 * Date: 11/9/13
 * Time: 2:50 PM
 */

namespace Encore\CustomerBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class PaymentController extends BaseController
{

    /**
     * @Route("/payment",name="encore_payment")
     */
    public function paymentAction()
    {
        $request = $this->getRequest();

        $datas = $request->request->all();

        return $this->render("EncoreCustomerBundle:Payment:payment-gateway.html.twig",["data" => $datas]);
    }

    /**
     * @Route("/summary",name="encore_summary")
     */
    public function summaryAction()
    {
//        $request = $this->getRequest();

//        $datas = $request->request->all();

//        $event = $this->em->getRepository("EncoreCustomerBundle:Event")
//            ->find($datas["event_id"]);


        $datas = [];
        $event = $this->em->getRepository("EncoreCustomerBundle:Event")
            ->find(23);
        $datas["date"] = "2013-08-13 10:00";
        $datas["location"] = $event->getVenue()->getLocation();
        $datas["event"] = $event;
        $seatAllocationArray = explode(";", "row4col10;row4col11");
        $datas["seat-allocation"] = $seatAllocationArray;
        $datas["qty"] = count($seatAllocationArray);
        $datas["event_section"] = "Section A";
        $datas["price"] = explode(";", "100;200");
        $datas["totalPrice"] = 0;
        foreach ($datas["price"] as $price) {
            $datas["totalPrice"] += intval($price);
        }

        $datas["price"] = explode(";", "100;200");

//        $seatAllocationArray = explode(";", $datas["event_seat_allocation"]);
//        return $this->render("EncoreCustomerBundle:Payment:summary.html.twig");
        return $this->render("EncoreCustomerBundle:Payment:summary.html.twig"
            , ["data" => $datas]);
    }

} 