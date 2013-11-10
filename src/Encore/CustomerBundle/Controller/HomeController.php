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
        if($this->isLoggedIn()){
            if(!$this->authenticatedUser->isEnabled()){
                return $this->redirect($this->generateUrl("encore_complete_profile"));
            }
        }

        /**
         * @var $eventManager \Encore\CustomerBundle\Model\EventManager
         */
        $eventManager = $this->get('encore.event_manager');
        $featuredEvents = $eventManager->getFeaturedEvents(3);
        $newEvents = $eventManager->getNewEvents(10);

        $param = [
            'featured_events' => $featuredEvents,
            'newEvents' => $newEvents,
        ];

        return $this->render('EncoreCustomerBundle:Home:index.html.twig', $param);
    }
}
