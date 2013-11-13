<?php

namespace Encore\CustomerBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Encore\CustomerBundle\Entity\Event;
use Symfony\Component\Validator\Constraints\DateTime;

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
        $featured = $eventManager->getFeaturedEvents(5);
        $featuredEvents = $this->trimEvents($featured);
        //only can be published featured event
        $new = $eventManager->getNewEvents(10);
        $newEvents = $this->trimEvents($new);

        $param = [
            'featured_events' => $featuredEvents,
            'new_events' => $newEvents,
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
                $eventHolders = $event->getEventHolders();
                if ($eventHolders) {
                    $earliest = null;
                    foreach ($eventHolders as $eventHolder) {
                        if ($earliest === null) {
                            $earliest = $eventHolder->getHeldDate();
                        } else {
                            if ($earliest > $eventHolder->getHeldDate()) {
                                $earliest = $eventHolder->getHeldDate();
                            }
                        }
                    }
                }

                $photos = $event->getPhotos();
                if ($photos) {
                    foreach ($photos as $photo) {
                        // first photo only
                        array_push(
                            $trimmedEvents,
                            [
                                "id" => $event->getId(),
                                "name" => $event->getName(),
                                "date" => $earliest->format("Y-m-d"),
                                "description" => $event->getDescription(),
                                "photo" => $photo
                            ]
                        );
                        break;
                    }
                } else {
                    return null;
                }
            }

            return $trimmedEvents;
        }

        return null;
    }
}
