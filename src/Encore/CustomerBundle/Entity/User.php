<?php

namespace Encore\CustomerBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
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

    const ROLE_ADMIN = 'ROLE_ADMIN';
    const ROLE_USER = 'ROLE_USER';
    const ROLE_ADMIN_USER = 'ROLE_ADMIN_USER';
    const ROLE_ADMIN_USER_ROLES = 'ROLE_ADMIN_USER_ROLES';
    const ROLE_EDITOR = 'ROLE_EDITOR';
    const ROLE_FACEBOOK = 'ROLE_FACEBOOK';
    const ROLE_NORMAL = 'ROLE_NORMAL';
    const ROLE_ADMIN_MERCHANT = 'ROLE_ADMIN_MERCHANT';
    const ROLE_MERCHANT = 'ROLE_MERCHANT';

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

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
