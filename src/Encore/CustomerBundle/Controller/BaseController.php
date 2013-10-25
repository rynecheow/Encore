<?php

namespace Encore\CustomerBundle\Controller;

use Encore\CustomerBundle\Entity\Customer;
use Encore\CustomerBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ORM\EntityManager;
/**
 * Base controller.
 *
 * Base controller for EncoreCustomerBundle controllers.
 *
 * @author Ryne Cheow
 * @version 1.0.0
 * @since version 1.00
 * created_at: 2013-10-12 12:00:00
 * updated_at:
 */

class BaseController extends Controller{

    /**
     * Request object
     * @var Request
     */
    protected $request;

    /**
     * Session object
     * @var Session
     */
    protected $session;

    /**
     * Current logged in authenticated user
     */
    protected $authenticatedUser;

    /**
     * The Doctrine entity manager.
     *
     * @var EntityManager
     */
    protected $em;

    /**
     * Set container to run custom functions when loading controller.
     *
     * (non-PHPdoc)
     * @see Symfony\Component\DependencyInjection.ContainerAware::setContainer()
     */
    public function setContainer(ContainerInterface $container = null)
    {
        parent::setContainer($container);
        $this->setCommons();
    }

    /**
     * Run common functions and set common variables.
     */
    private function setCommons()
    {
        $this->request = $this->getRequest();
        $this->session = $this->request->getSession();
        $this->em = $this->getDoctrine()->getManager();
        $this->authenticatedUser = $this->getAuthenticatedUser();

        /*
         * Add global variables to Twig.
         */
        $this->get('twig')->addGlobal('authenticated_user', $this->authenticatedUser);
        $this->get('twig')->addGlobal('current_route', $this->request->attributes->get('_route'));
    }

    /**
     * Check if a user is logged in.
     *
     * @return boolean Decision of whether a user is logged in.
     */
    public function isLoggedIn()
    {
        return ($this->authenticatedUser != null);
    }

    /**
     * Get the currently logged in user Doctrine entity object.
     *
     * @return User|null The currently logged in user Doctrine entity object.
     */
    private function getAuthenticatedUser()
    {
        return $this->container->get('fos.user_manager')->getAuthenticatedUser();
    }


}