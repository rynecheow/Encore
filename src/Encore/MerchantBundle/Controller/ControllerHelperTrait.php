<?php
/**
 * Created by PhpStorm.
 * User: sysadm
 * Date: 11/9/13
 * Time: 1:41 PM
 */

namespace Encore\MerchantBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerInterface;

trait ControllerHelperTrait
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
