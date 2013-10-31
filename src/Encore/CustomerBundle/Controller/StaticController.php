<?php

namespace Encore\CustomerBundle\Controller;



class StaticController extends BaseController{
    public function aboutAction(){
        return $this->render("EncoreCustomerBundle:Navigation:about-us.html.twig");
    }

    public function contactAction(){
        return $this->render("EncoreCustomerBundle:Navigation:contact-us.html.twig");
    }

    public function siteAction(){
        return $this->render("EncoreCustomerBundle:Navigation:site-map.html.twig");
    }

    public function purchaseTermsAction(){
        return $this->render("EncoreCustomerBundle:Navigation:purchase-terms.html.twig");
    }

    public function websiteTermsAction(){
        return $this->render("EncoreCustomerBundle:Navigation:website-terms.html.twig");
    }

    public function privacyAction(){
        return $this->render("EncoreCustomerBundle:Navigation:privacy.html.twig");
    }
}