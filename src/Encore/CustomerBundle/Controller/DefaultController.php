<?php

namespace Encore\CustomerBundle\Controller;

class DefaultController extends BaseController
{
    public function indexAction($name)
    {
        return $this->render('EncoreCustomerBundle:Default:index.html.twig', array('name' => $name));
    }
}
