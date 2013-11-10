<?php
/**
 * Created by PhpStorm.
 * User: sysadm
 * Date: 11/8/13
 * Time: 3:05 PM
 */

namespace Encore\MerchantBundle\Helper;

use Symfony\Component\Security\Core\SecurityContext;
use Doctrine\ORM\EntityManager;
use Encore\CustomerBundle\Entity\User;

class AuthenticationHelper
{

    /**
     * @var SecurityContext
     */
    private $sc;

    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(SecurityContext $sc, EntityManager $em)
    {
        $this->sc = $sc;
        $this->em = $em;
    }

    /**
     * Gets the currently logged in user.
     *
     * @return User
     */
    public function getLoggedInUser()
    {
        if (null === ($token = $this->sc->getToken())) {
            return null;
        }

        if (!is_object($user = $token->getUser())) {
            return null;
        }

        if (!$this->sc->isGranted('ROLE_MERCHANT')) {
            return null;
        }

        $user = $this->em->find('EncoreCustomerBundle:User', $user->getId());

        return $user;
    }
}
