<?php
/**
 * Created by PhpStorm.
 * User: sysadm
 * Date: 10/22/13
 * Time: 10:21 PM
 */

namespace Encore\CustomerBundle\Services;

use Encore\CustomerBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\SecurityContext;


class EncoreUserManager {
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
     * @return boolean
     */
    public function checkEmailAvailability($email)
    {
        $userEmailRepo = $this->em->getRepository('EncoreCustomerBundle:User');
        $matchedUserEmails = $userEmailRepo->findBy(array('email' => $email));

        foreach ($matchedUserEmails as $matchedUserEmail) {
            if ($matchedUserEmail->isVerified()) {
                return false;
            }
        }

        return true;
    }

    public function createNewEmail(User $user)
    {
        $userEmail = new UserEmail();
        $userEmail->setEmail(null);
        $userEmail->setVerificationCode(null);
        $userEmail->setVerifiedAt(null);
        $userEmail->setUser($user);

        return $userEmail;
    }

    public function generateEmailVerificationCode(UserEmail $userEmail)
    {
        $email = $userEmail->getEmail();

        if (null !== $email) {
            $verificationCode = hash("sha512",
                $email . $userEmail->getUser()->getSalt()
            );

            $userEmail->setVerificationCode($verificationCode);
            $userEmail->setVerifiedAt(null);
        }
    }

    public function removeEmail(UserEmail $userEmail)
    {
        $this->em->remove($userEmail);
    }

    /**
     * Checks the availability of a mobile number.
     *
     * @param string $mobileNo
     * @return boolean
     */
    public function checkMobileNoAvailability($mobileNo)
    {
        $userMobileNoRepo = $this->em->getRepository('AprojectsCorpickBundle:UserMobileNo');
        $matchedUserMobileNos = $userMobileNoRepo->findBy(array('mobileNo' => $mobileNo));

        foreach ($matchedUserMobileNos as $matchedUserMobileNo) {
            if ($matchedUserMobileNo->isVerified()) {
                return false;
            }
        }

        return true;
    }

    public function createNewMobileNo(User $user)
    {
        $userMobileNo = new UserMobileNo();
        $userMobileNo->setMobileNo(null);
        $userMobileNo->setVerificationCode(null);
        $userMobileNo->setVerifiedAt(null);
        $userMobileNo->setUser($user);

        return $userMobileNo;
    }

    /**
     * Generates a verification code for mobile number.
     *
     * @param UserMobileNo $userMobileNo
     *
     * @return string
     */
    public function generateMobileVerificationCode(UserMobileNo $userMobileNo)
    {
        $mobileNo = $userMobileNo->getMobileNo();

        if (null !== $mobileNo) {
            // note: duplicates are fine
            $verificationCode = CodeGenerator::generateRandomCode(5, [
                    'allowed' => [
                        'numbers' => '123456789',
                        'alphabets' => [
                            'lower_case' => '',
                            'upper_case' => '',
                        ],
                        'symbols' => '',
                    ],
                ]);

            $userMobileNo->setVerificationCode($verificationCode);
            $userMobileNo->setVerifiedAt(null);
        }
    }

    /**
     * Verifies a mobile number.
     *
     * @param UserMobileNo $userMobileNo
     * @param string       $verificationCode
     *
     * @return boolean
     */
    public function verifyMobileNo(UserMobileNo $userMobileNo, $verificationCode)
    {
        if ($userMobileNo->getVerificationCode() === $verificationCode) {
            $now = new \DateTime();

            $userMobileNo->setVerificationCode(null);
            $userMobileNo->setVerifiedAt($now);

            return true;
        }

        return false;
    }

    public function removeMobileNo(UserMobileNo $userMobileNo)
    {
        $this->em->remove($userMobileNo);
    }

    public function createNewAddress(User $user)
    {
        $userAddress = new UserShippingAddress();
        $userAddress->setOwn(true);
        $userAddress->setUser($user);

        return $userAddress;
    }

    public function removeAddress(UserShippingAddress $address)
    {
        $this->em->remove($address);
    }

    public function removeObsoleteAddresses(User $user)
    {
        $currentAddresses = $user->getShippingAddresses();

        $userAddressRepo = $this->em->getRepository('AprojectsCorpickBundle:UserShippingAddress');
        $originalAddresses = $userAddressRepo->findBy(array('user' => $user->getId()));

        foreach ($originalAddresses as $address) {
            if (!$currentAddresses->contains($address)) {
                $this->removeAddress($address);
            }
        }
    }

    public function createNewAlias(User $user)
    {
        $urlAlias = new UrlAlias();
        $urlAlias->setResourceType('user');
        $urlAlias->setResourceRid($user->getId());

        return $urlAlias;
    }

    public function updateAlias(User $user)
    {
        $urlAliasRepo = $this->em->getRepository('AprojectsCorpickBundle:UrlAlias');
        $urlAlias = $urlAliasRepo->findOneBy(array(
                'resourceType' => 'user',
                'resourceRid' => $user->getId()
            ));

        if (null === $urlAlias) {
            $urlAlias = $this->createNewAlias($user);
            $this->em->persist($urlAlias);
        }

        $urlAlias->setAlias($user->getUsernameCanonical());
    }

    /**
     * Checks whether a user has its role authenticated.
     *
     * @return boolean Decision of whether a user is authenticated.
     */
    private function isAuthenticated()
    {
        return ($this->sc->isGranted('ROLE_FACEBOOK') || $this->sc->isGranted('ROLE_NORMAL'));
    }

    /**
     * Get the currently logged in user Doctrine entity object.
     *
     * @return User|NULL The currently logged in user Doctrine entity object.
     */
    public function getLoggedInUser()
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
                ->getRepository('AprojectsCorpickBundle:User')
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
    public function isLoggedIn() {
        return ($this->getLoggedInUser() != null);
    }

    /**
     *
     */
    public function removeDuplicateEmailAccounts($email){
        $userEmails = $this->em->getRepository("AprojectsCorpickBundle:UserEmail")->findByEmail($email);
        foreach ($userEmails as $userEmail) {
            if ($userEmail->getVerificationCode()) {
                $this->em->remove($userEmail->getUser());
            }
        }
    }
} 