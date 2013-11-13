<?php
/**
 * Created by PhpStorm.
 * User: kelvin
 * Date: 08/11/2013
 * Time: 14:37
 */

namespace Encore\CustomerBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Session\Session;

class SearchController extends BaseController
{

    /**
     * @Route("/search", name="encore_global_search")
     */
    public function globalSearchAction()
    {
        $params = [];
        /**
         * @var $session Session
         */
        $session = $this->get('session');
        $session->save();

        $categories = [
            "Performing Arts",
            "Concert",
            "Art",
            "Exhibition"
        ];

        $request = $this->getRequest();
        if ($request->getMethod() === "GET") {
            $qparams = $request->query->all();
            if ($qparams) {
                if (isset($qparams['keywords']) && $qparams['keywords']) {
                    /**
                     * @var $searcher \Encore\CustomerBundle\Services\EncoreSearch
                     */
                    $searcher = $this->get('encore.encore_search');
                    $search_results = $searcher->performFullSearch($qparams);
                    /**
                     * @var $events \Encore\CustomerBundle\Entity\Event[]
                     */
                    $events = $search_results['data']['events'];
                    $params = [];
                    foreach ($events as $event) {
                        /**
                         * @var $date \DateTime
                         */
                        $date = $event->getEventHolders()[0]->getHeldDate();
                        $photo = $event->getPhotos()[0];
                        $location = $event->getVenue()->getLocation();
                        $date = $date->format("Y-m-d");

                        switch ($event->getType()) {
                            case 1 :
                                $type = "Performing Arts";
                                break;
                            case 2 :
                                $type = "Concert";
                                break;
                            case 3 :
                                $type = "Art";
                                break;
                            case 4 :
                                $type = "Exhibition";
                                break;
                            default:
                                $type = "Others";
                                break;
                        }

                        $params[] = [
                           "type" => $type,
                            "id" =>$event->getId(),
                            "location"=>$location,
                            "heldDate" => $date,
                            "name" => $event->getName(),
                            "imagePath" => $photo
                        ];

                    }


                    if (count($params) === 0) {
                        $params = null;
                    }

                    return $this->render(
                        'EncoreCustomerBundle:Search:search.html.twig',
                        [
                            "event" => $params,
//                            "categoryList" => $categories,
                        ]
                    );
                }
            }
        }

        return $this->render(
            'EncoreCustomerBundle:Search:search.html.twig',
            ['categoryList' => $categories]
        );
    }
} 