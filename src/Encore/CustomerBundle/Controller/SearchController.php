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


                    $params = [
                        "search_results" => $search_results
                    ];

                    return $this->render('EncoreCustomerBundle:Search:search.html.twig', $params);
                }
            }
        }

        return $this->render('EncoreCustomerBundle:Search:empty-search.html.twig', $params);
    }
} 