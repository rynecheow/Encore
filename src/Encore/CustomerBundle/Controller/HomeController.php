<?php

namespace Encore\CustomerBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
/**
 * @Route("/")
 */
class HomeController extends BaseController
{

    /**
     * @Route("", name="encore_home", options={"expose"=true})
     * @Method({"GET"})
     */
    public function indexAction()
    {
        $eventManager = $this->get('encore.event_manager');
        $featuredEvents = $eventManager->getFeaturedEvents(3);
        $newEvents = $eventManager->getNewEvents(10);


        $param = [
            'featured_events' => $featuredEvents,
        ];

        return $this->render('EncoreCustomerBundle:Home:index.html.twig', $param);
    }
}
