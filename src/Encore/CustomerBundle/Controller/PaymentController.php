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

        return $this->render("EncoreCustomerBundle:Payment:payment-gateway.html.twig");
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

//        $seatAllocationArray = explode(";", $datas["event_seat_allocation"]);
        return $this->render("EncoreCustomerBundle:Payment:summary.html.twig");
//        return $this->render("EncoreCustomerBundle:Payment:summary.html.twig"
//            ,["event"=> $event , "section"=>$datas["event_section"],
//            "qty"=> $datas["event_ticket_qty"],"seat-allocation" => $seatAllocationArray]);
    }

} 