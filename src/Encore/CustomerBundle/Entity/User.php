<?php

namespace Encore\CustomerBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use FOS\UserBundle\Model\User as BaseUser;
/**
 * User
 *
 * @ORM\Table(name="User",
 * uniqueConstraints={@ORM\UniqueConstraint(name="idx_unq_username", columns={"username"})})
 * @ORM\Entity(repositoryClass="Encore\CustomerBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    use ORMBehaviors\Timestampable\Timestampable;

    const ROLE_ADMIN = 'ROLE_ADMIN';
    const ROLE_ADMIN_USER = 'ROLE_ADMIN_USER';
    const ROLE_ADMIN_USER_ROLES = 'ROLE_ADMIN_USER_ROLES';
    const ROLE_EDITOR = 'ROLE_EDITOR';
    const ROLE_FACEBOOK = 'ROLE_FACEBOOK';
    const ROLE_NORMAL = 'ROLE_NORMAL';
    const ROLE_ADMIN_MERCHANT = 'ROLE_ADMIN_MERCHANT';
    const ROLE_MERCHANT= 'ROLE_MERCHANT';

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

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
     * @var \Encore\CustomerBundle\Entity\Customer
     * @ORM\OneToOne(targetEntity="Encore\CustomerBundle\Entity\Customer", mappedBy="user");
     */
    private $customer;

    /**
     * @var \Encore\CustomerBundle\Entity\Merchant
     * @ORM\OneToOne(targetEntity="Encore\CustomerBundle\Entity\Merchant", mappedBy="user");
     */
    private $merchant;


    /**
     * @var \Encore\CustomerBundle\Entity\UserEmail[]
     *
     * @ORM\OneToMany(targetEntity="Encore\CustomerBundle\Entity\UserEmail", mappedBy="user", fetch="EXTRA_LAZY")
     */
    private $emails;


    public function __construct()
    {
        parent::__construct();
        $this->emails = new ArrayCollection();
    }


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
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
     * @param \Encore\CustomerBundle\Entity\Customer $customer
     *
     * @return User
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * @return \Encore\CustomerBundle\Entity\Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @param \Encore\CustomerBundle\Entity\Merchant $merchant
     *
     * @return User
     */
    public function setMerchant($merchant)
    {
        $this->merchant = $merchant;

        return $this;
    }

    /**
     * @return \Encore\CustomerBundle\Entity\Merchant
     */
    public function getMerchant()
    {
        return $this->merchant;
    }

    /**
     * @param \Encore\CustomerBundle\Entity\UserEmail[] $emails
     */
    public function setEmails($emails)
    {
        $this->emails = $emails;
    }

    /**
     * @return \Encore\CustomerBundle\Entity\UserEmail[]
     */
    public function getEmails()
    {
        return $this->emails;
    }
}
