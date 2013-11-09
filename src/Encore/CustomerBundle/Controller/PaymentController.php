<?php
/**
 * Created by PhpStorm.
 * User: sysadm
 * Date: 11/9/13
 * Time: 2:50 PM
 */

namespace Encore\CustomerBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class PaymentController extends BaseController{
    /**
     * @Route("/payment",name="encore_payment")
     */
    public function paymentAction(){
        return $this->render("EncoreCustomerBundle:Payment:payment-gateway.html.twig");
    }

} 