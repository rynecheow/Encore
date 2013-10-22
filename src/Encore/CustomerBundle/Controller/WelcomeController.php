<?php

namespace Encore\CustomerBundle\Controller;


class WelcomeController extends BaseController
{
    public function indexAction()
    {
        return $this->render('EncoreCustomerBundle:Welcome:index.html.twig');
    }
}
