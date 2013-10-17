<?php

namespace Encore\CustomerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use FOS\UserBundle\Model\User as BaseUser;
/**
 * User
 *
 * @ORM\Table(name="User")
 * @ORM\Entity(repositoryClass="Encore\CustomerBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    use ORMBehaviors\Timestampable\Timestampable;

    const ROLE_MERCHANT = 'ROLE_MERCHANT';
    const ROLE_FACEBOOK = 'ROLE_FACEBOOK';
    const ROLE_ADMIN = 'ROLE_ADMIN';
    const ROLE_NORMAL = 'ROLE_NORMAL';

    /**
     * @var integer
     *
     * @ORM\Column(name="userID", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $userID;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="deactivatedAt", type="datetime", nullable=true)
     */
    protected $deactivatedAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="bannedAt", type="datetime")
     */
    protected $bannedAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="signedUpAt", type="datetime")
     */
    protected $signedUpAt;

    /**
     * @var string
     *
     * @ORM\Column(name="mobileNumber", type="string", length=200)
     */
    protected $mobileNumber;


    /**
     * Set deactivatedAt
     *
     * @param \DateTime $deactivatedAt
     * @return User
     */
    public function setDeactivatedAt($deactivatedAt)
    {
        $this->deactivatedAt = $deactivatedAt;
    
        return $this;
    }

    /**
     * Get deactivatedAt
     *
     * @return \DateTime 
     */
    public function getDeactivatedAt()
    {
        return $this->deactivatedAt;
    }

    /**
     * Set bannedAt
     *
     * @param \DateTime $bannedAt
     * @return User
     */
    public function setBannedAt($bannedAt)
    {
        $this->bannedAt = $bannedAt;
    
        return $this;
    }

    /**
     * Get bannedAt
     *
     * @return \DateTime 
     */
    public function getBannedAt()
    {
        return $this->bannedAt;
    }

    /**
     * Set signedUpAt
     *
     * @param \DateTime $signedUpAt
     * @return User
     */
    public function setSignedUpAt($signedUpAt)
    {
        $this->signedUpAt = $signedUpAt;
    
        return $this;
    }

    /**
     * Get signedUpAt
     *
     * @return \DateTime 
     */
    public function getSignedUpAt()
    {
        return $this->signedUpAt;
    }

    /**
     * Set mobileNumber
     *
     * @param string $mobileNumber
     * @return User
     */
    public function setMobileNumber($mobileNumber)
    {
        $this->mobileNumber = $mobileNumber;
    
        return $this;
    }

    /**
     * Get mobileNumber
     *
     * @return string 
     */
    public function getMobileNumber()
    {
        return $this->mobileNumber;
    }
}
