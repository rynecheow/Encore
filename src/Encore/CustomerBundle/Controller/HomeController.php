<?php

namespace Encore\CustomerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class HomeController extends Controller
{

    /**
     * @Route("/", name="encore_home")
     */
    public function indexAction()
    {
        return $this->render('EncoreCustomerBundle:Home:index.html.twig');
    }
}
