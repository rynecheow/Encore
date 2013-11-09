<?php

namespace Encore\MerchantBundle\Controller;

use Encore\CustomerBundle\Entity\Customer;
use Encore\CustomerBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ORM\EntityManager;
use Encore\MerchantBundle\Helper\AuthenticationHelper;
/**
 * Base controller.
 *
 * Base controller for EncoreMerchantBundle controllers.
 *
 * @author  Ryne Cheow
 * @version 1.0.0
 * @since   version 1.00
 * created_at: 2013-11-07 12:00:00
 * updated_at:
 */

class BaseController extends Controller
{

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * Set container to run custom functions when loading controller.
     *
     * (non-PHPdoc)
     *
     * @see Symfony\Component\DependencyInjection.ContainerAware::setContainer()
     */
    public function setContainer(ContainerInterface $container = null)
    {
        parent::setContainer($container);

        $this->request = $this->getRequest();
        $this->em = $this->getDoctrine()->getManager();

        /*
         * Add global variables to Twig.
         */
        $this->get('twig')->addGlobal('currency', $this->container->getParameter('encore.currency'));
    }


    /**
     * Gets the currently logged in user.
     *
     * @return \Encore\CustomerBundle\Entity\User
     */
    protected function getLoggedInUser()
    {
        /**
         * @var $authenticationHelper AuthenticationHelper
         */
        $authenticationHelper = $this->container->get('encore_merchant.helper.authentication');

        return $authenticationHelper->getLoggedInUser();
    }

    /**
     * Simple notification flash message
     */
    protected function pushFlashMessage($status, $message)
    {
        $this->getRequest()->getSession()->getFlashBag()->add($status, $message);
    }

}