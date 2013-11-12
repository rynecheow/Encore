<?php
/**
 * Created by PhpStorm.
 * User: Ryne Cheow
 * Date: 10/22/13
 * Time: 10:21 PM
 */

namespace Encore\CustomerBundle\Services;

use Encore\CustomerBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\SecurityContext;
use Encore\CustomerBundle\Entity\UserEmail;

class EncoreUserManager
{

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var SecurityContext
     */
    private $sc;

    /**
     * @param EntityManager   $em The Doctrine entity manager.
     * @param SecurityContext $sc The Symfony security context.
     */
    public function __construct(EntityManager $em, SecurityContext $sc)
    {
        $this->em = $em;
        $this->sc = $sc;
    }

    /**
     * Checks the availability of an email address.
     *
     * @param string $email
     *
     * @return boolean
     */
    public function checkEmailAvailability($email)
    {
        $userEmailRepo = $this->em->getRepository('EncoreCustomerBundle:UserEmail');
        $matchedUserEmails = $userEmailRepo->findBy(array('email' => $email));

        return count($matchedUserEmails) == 0;

    }

    public function createNewEmail(User $user)
    {
        $userEmail = new UserEmail();
        $userEmail->setEmail(null);
        $userEmail->setUser($user);

        return $userEmail;
    }

    public function removeEmail(UserEmail $userEmail)
    {
        $this->em->remove($userEmail);
    }

    /**
     * Checks whether a user has its role authenticated.
     *
     * @return boolean Decision of whether a user is authenticated.
     */
    private function isAuthenticated()
    {
        return ($this->sc->isGranted('ROLE_USER') || $this->sc->isGranted('ROLE_ADMIN'));
    }

    /**
     * Get the currently logged in user Doctrine entity object.
     *
     * @return User|NULL The currently logged in user Doctrine entity object.
     */
    public function getAuthenticatedUser()
    {

        if ($this->isAuthenticated()) {
            if (null === $token = $this->sc->getToken()) {
                return null;
            }

            if (!is_object($user = $token->getUser())) {
                return null;
            }
            $token = null;

            $user = $this->em
                ->getRepository('EncoreCustomerBundle:User')
                ->find($user->getId());

            return $user;
        }

        return null;
    }

    /**
     * Check if a user is logged in.
     *
     * @return boolean Decision of whether a user is logged in.
     */
    public function isLoggedIn()
    {
        return ($this->getAuthenticatedUser() != null);
    }
} 