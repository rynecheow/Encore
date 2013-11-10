<?php

namespace Encore\CustomerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Customer
 *
 * @ORM\Table(name="Customer")
 * @ORM\Entity(repositoryClass="Encore\CustomerBundle\Repository\CustomerRepository")
 */
class Customer
{

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
     * @ORM\Column(name="firstName", type="string", length=200)
     */
    protected $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=200)
     */
    protected $lastName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthDate", type="datetime")
     */
    protected $birthDate;

    /**
     * @var string
     *
     * @ORM\Column(name="contactNo", type="string", length=200)
     */
    protected $contactNo;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=200)
     */
    protected $address;

    /**
     * @var \Encore\CustomerBundle\Entity\CardInfo
     * @ORM\OneToOne(targetEntity="Encore\CustomerBundle\Entity\CardInfo", inversedBy="owner");
     * @ORM\JoinColumn(name="cardInfoID", referencedColumnName="id", nullable=true);
     */
    private $cardInfo;

    /**
     * @var \Encore\CustomerBundle\Entity\TicketOrder
     * @ORM\OneToMany(targetEntity="Encore\CustomerBundle\Entity\TicketOrder", mappedBy="customer")
     */
    private $ticketOrders;

    /**
     * @var \Encore\CustomerBundle\Entity\User
     * @ORM\OneToOne(targetEntity="Encore\CustomerBundle\Entity\User", inversedBy="customer")
     * @ORM\JoinColumn(name="userID", referencedColumnName="id");
     */
    private $user;

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
     * @param \Encore\CustomerBundle\Entity\TicketOrder $ticketOrders
     *
     * @return Customer
     */
    public function setTicketOrders($ticketOrders)
    {
        $this->ticketOrders = $ticketOrders;
    }

    /**
     * @param \Encore\CustomerBundle\Entity\User $user
     *
     * @return Customer
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return \Encore\CustomerBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return \Encore\CustomerBundle\Entity\TicketOrder
     */
    public function getTicketOrders()
    {
        return $this->ticketOrders;
    }

    /**
     * @param \Encore\CustomerBundle\Entity\CardInfo $cardInfo
     *
     * @return Customer
     */
    public function setCardInfo($cardInfo)
    {
        $this->cardInfo = $cardInfo;

        return $this;
    }

    /**
     * @return \Encore\CustomerBundle\Entity\CardInfo
     */
    public function getCardInfo()
    {
        return $this->cardInfo;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return Customer
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
     * Set firstName
     *
     * @param string $firstName
     *
     * @return Customer
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return Customer
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set birthDate
     *
     * @param \DateTime $birthDate
     *
     * @return Customer
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    /**
     * Get birthDate
     *
     * @return \DateTime
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * Set contactNo
     *
     * @param string $contactNo
     *
     * @return Customer
     */
    public function setContactNo($contactNo)
    {
        $this->contactNo = $contactNo;

        return $this;
    }

    /**
     * Get contactNo
     *
     * @return string
     */
    public function getContactNo()
    {
        return $this->contactNo;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return Customer
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }
}
