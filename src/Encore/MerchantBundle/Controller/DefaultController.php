<?php

namespace Encore\MerchantBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('EncoreMerchantBundle:Default:index.html.twig', array('name' => $name));
    }
}
