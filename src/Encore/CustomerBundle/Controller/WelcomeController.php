<?php

namespace Encore\CustomerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
class WelcomeController extends Controller
{
    public function indexAction()
    {
        return $this->render('EncoreCustomerBundle:Welcome:index.html.twig');
    }
}
