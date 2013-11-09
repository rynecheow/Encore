<?php
/**
 * Created by PhpStorm.
 * User: sysadm
 * Date: 11/7/13
 * Time: 11:05 PM
 */

namespace Encore\MerchantBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use JMS\SecurityExtraBundle\Annotation\PreAuthorize;
use Symfony\Component\Security\Core\SecurityContext;

/**
 * @Route("/")
 */
class HomeController extends BaseController
{

    /**
     * @Route("/", name="encore_merchant_home")
     *
     * @PreAuthorize("hasRole('ROLE_MERCHANT')")
     *
     */
    public function indexAction()
    {
        //Return analytics
        return $this->render("EncoreMerchantBundle:Home:index.html.twig");
    }

    /**
     * @Route("/login", name="encore_merchant_login")
     */
    public function loginAction()
    {
        if ($this->getLoggedInUser()) {
            return $this->redirect($this->generateUrl('encore_merchant_home'));
        }

        $session = $this->getRequest()->getSession();
        $loginError = $session->get(SecurityContext::AUTHENTICATION_ERROR);

        // Set login error message.
        if ($loginError != null) {
            $this->pushFlashMessage('error', 'Invalid username or password.');
        }

        // Avoid login error message to be appeared everytime when refreshing the page.
        if ($session->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }

        return $this->render("EncoreMerchantBundle:Security:login.html.twig");
    }

    /**
     * @Route("/logout", name="encore_merchant_logout")
     */
    public function logoutAction()
    {
    }

    /**
     * @Route("/login_check", name="encore_merchant_login_check")
     */
    public function loginCheckAction()
    {
    }

}
