<?php

namespace Encore\CustomerBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Encore\CustomerBundle\Entity\Event;

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
        if ($this->isLoggedIn()) {
            if (!$this->authenticatedUser->isEnabled()) {
                return $this->redirect($this->generateUrl("encore_complete_profile"));
            }
        }

        /**
         * @var $eventManager \Encore\CustomerBundle\Model\EventManager
         */
        $eventManager = $this->get('encore.event_manager');
        $featured = $eventManager->getFeaturedEvents(1);
        $featuredEvents = $this->trimEvents($featured);

        $new = $eventManager->getNewEvents(10);
        $newEvents = $this->trimEvents($new);

        $param = [
            'featured_events' => $featuredEvents,
            'newEvents' => $newEvents,
        ];

        return $this->render('EncoreCustomerBundle:Home:index.html.twig', $param);
    }

    /**
     * @param Event[] $events
     * @return array|null
     */
    private function trimEvents($events)
    {
        if (isset($events) && $events != null) {
            $trimmedEvents = [];
            foreach ($events as $event) {
                $photos = $event->getPhotos();
                if($photos){
                    foreach ($photos as $photo) {
                        // first photo only
                        array_push(
                            $trimmedEvents,
                            [
                                "id" => $event->getId(),
                                "name" => $event->getName(),
                                "description" => $event->getDescription(),
                                "photo" => $photo->getImagePath()
                            ]
                        );
                        break;
                    }
                }else{
                    return null;
                }
            }

            return $trimmedEvents;
        }

        return null;
    }
}
