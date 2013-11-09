<?php
/**
 * Created by PhpStorm.
 * User: kelvin
 * Date: 08/11/2013
 * Time: 14:37
 */

namespace Encore\CustomerBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class SearchController extends BaseController{
    /**
     * @Route("/advance-search",name="encore_advance_search")
     */

    public function searchAction(){
        return $this->render("EncoreCustomerBundle:Search:advance-search.html.twig");
    }

    /**
     * @Route("/search", name="encore_global_search")
     */
    public function globalSearchAction()
    {
        $params = [];
        $session = $this->get('session');
        $session->save();
        if ($this->getRequest()->getMethod() === "GET") {
            $qparams = $this->getRequest()->query->all();
            if ($qparams) {
                if (isset($qparams['q']) && $qparams['q']) {
                    if (!isset($qparams['type'])) {
                        $qparams['type'] = "default";
                    }
                    $qparams['user_id'] = ($this->authenticatedUser) ? $this->authenticatedUser->getId() : 0;
                    $search_results = $this->get('encore.encore_search')->doFullSearch($qparams);
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