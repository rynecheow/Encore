<?php

namespace Encore\CustomerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class WelcomeController extends Controller
{

    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('EncoreCustomerBundle:Welcome:index.html.twig');
    }
}
