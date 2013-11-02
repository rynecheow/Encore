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
        return $this->render("EncoreCustomerBundle:Navigation:about-us.html.twig");
    }

    /**
     * @Route("/contact", name="encore_contact")
     */
    public function contactAction()
    {
        return $this->render("EncoreCustomerBundle:Navigation:contact-us.html.twig");
    }

    /**
     * @Route("/sitemap", name="encore_sitemap")
     */
    public function siteAction()
    {
        return $this->render("EncoreCustomerBundle:Navigation:site-map.html.twig");
    }

    /**
     * @Route("/terms/purchase", name="encore_terms_purchase")
     */
    public function purchaseTermsAction()
    {
        return $this->render("EncoreCustomerBundle:Navigation:purchase-terms.html.twig");
    }

    /**
     * @Route("/terms/encore", name="encore_terms_encore")
     */
    public function websiteTermsAction()
    {
        return $this->render("EncoreCustomerBundle:Navigation:website-terms.html.twig");
    }

    /**
     * @Route("/privacy", name="encore_privacy")
     */
    public function privacyAction()
    {
        return $this->render("EncoreCustomerBundle:Navigation:privacy.html.twig");
    }
}