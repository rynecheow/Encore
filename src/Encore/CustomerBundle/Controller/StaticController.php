<?php

namespace Encore\CustomerBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class StaticController extends BaseController
{

    /**
     * @Route("/about", name="encore_about")
     */
    public function aboutAction()
    {
        return $this->render("EncoreCustomerBundle:Static:about-us.html.twig");
    }

    /**
     * @Route("/terms", name="encore_terms_purchase")
     */
    public function purchaseTermsAction()
    {
        return $this->render("EncoreCustomerBundle:Static:purchase-terms.html.twig");
    }

    /**
     * @Route("/privacy", name="encore_privacy")
     */
    public function privacyAction()
    {
        return $this->render("EncoreCustomerBundle:Static:privacy.html.twig");
    }
}