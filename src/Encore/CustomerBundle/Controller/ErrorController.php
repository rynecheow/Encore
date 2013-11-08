<?php
/**
 * Created by PhpStorm.
 * User: kelvin
 * Date: 07/11/2013
 * Time: 22:10
 */

namespace Encore\CustomerBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ErrorController extends BaseController{

    /**
     * @route("/error",name="encore_error")
     */
    public function errorAction(){
        return $this->render("EncoreCustomerBundle:Exception:error.html.twig");
    }

} 