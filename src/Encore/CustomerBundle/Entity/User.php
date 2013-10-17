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
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=200)
     */
    protected $username;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=200)
     */
    protected $email;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean")
     */
    protected $enabled;

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
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=200)
     */
    protected $salt;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=200)
     */
    protected $password;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="lastLogin", type="datetime")
     */
    protected $lastLogin;

    /**
     * @var array
     *
     * @ORM\Column(name="roleles", type="array")
     */
    protected $roles;

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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;
    
        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     * @return User
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    
        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean 
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

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
     * Set salt
     *
     * @param string $salt
     * @return User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    
        return $this;
    }

    /**
     * Get salt
     *
     * @return string 
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;
    
        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set lastLogin
     *
     * @param \DateTime $lastLogin
     * @return User
     */
    public function setLastLogin(\DateTime $lastLogin = null)
    {
        $this->lastLogin = $lastLogin;
    
        return $this;
    }

    /**
     * Get lastLogin
     *
     * @return \DateTime 
     */
    public function getLastLogin()
    {
        return $this->lastLogin;
    }

    /**
     * Set roles
     *
     * @param array $roles
     *
     * @return User
     */
    public function setRoles(array $roles)
    {
        $this->roles = $roles;
    
        return $this;
    }

    /**
     * Get roles
     *
     * @return array 
     */
    public function getRoles()
    {
        return $this->roles;
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
