<?php
/**
 * Created by PhpStorm.
 * User: sysadm
 * Date: 11/7/13
 * Time: 11:05 PM
 */

namespace Encore\MerchantBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class HomeController extends BaseController
{

    /**
     * @Route("/", name="encore_merchant_home")
     */
    public function indexAction()
    {
        return $this->render("EncoreMerchantBundle:Home:index.html.twig");
    }


}
