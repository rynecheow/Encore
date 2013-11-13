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
                    $events = $search_results['data']['events'];

                    foreach ($events as $event) {
                        /**
                         * @var $date \DateTime
                         */
                        $date = $event['heldDate'];
                        $event['heldDate'] = $date->format("Y-m-d");
                        $params[] = $event;
                    }

                    return $this->render(
                        'EncoreCustomerBundle:Search:search.html.twig',
                        [
                            "event" => $params,
                            "categoryList" => $categories,
                        ]
                    );
                }
            }
        }

        return $this->render('EncoreCustomerBundle:Search:search.html.twig', ['categoryList' => $categories]);
    }
} 