<?php

namespace Encore\CustomerBundle\Controller;

class LoginController extends BaseController{

    public function indexAction(){
        return $this->render("EncoreCustomerBundle:Login:index.html.twig");
    }
} 