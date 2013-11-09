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
} 