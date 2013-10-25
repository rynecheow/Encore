<?php
/**
 * Created by PhpStorm.
 * User: sysadm
 * Date: 10/25/13
 * Time: 10:29 PM
 */

namespace Encore\CustomerBundle\Controller;


class RegistrationSuccessController extends BaseController
{
    public function showAction()
    {
        return $this->render("EncoreCustomerBundle:Registration:information.html.twig");
    }
} 