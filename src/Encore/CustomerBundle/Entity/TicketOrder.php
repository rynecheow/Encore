<?php

namespace Encore\CustomerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TicketOrder
 *
 * @ORM\Table(name="TicketOrder")
 * @ORM\Entity(repositoryClass="Encore\CustomerBundle\Repository\TicketOrderRepository")
 */
class TicketOrder
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
     * @var \DateTime
     *
     * @ORM\Column(name="purchaseDate", type="datetime")
     */
    protected $purchaseDate;

    /**
     * @var float
     *
     * @ORM\Column(name="totalPaid", type="decimal")
     */
    protected $totalPaid;

    /**
     * @var string
     *
     * @ORM\Column(name="secureCardNumber", type="object")
     */
    private $secureCardNumber;

    /**
     * @var \Encore\CustomerBundle\Entity\Ticket[]
     * @ORM\OneToMany(targetEntity="Encore\CustomerBundle\Entity\Ticket", mappedBy="ticketOrder")
     */
    private $tickets;

    /**
     * @var \Encore\CustomerBundle\Entity\Customer
     * @ORM\ManyToOne(targetEntity="Encore\CustomerBundle\Entity\Customer", inversedBy="ticketOrders")
     * @ORM\JoinColumn(name="customerID", referencedColumnName="id", nullable=false)
     */
    private $customer;

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
     * @param \Encore\CustomerBundle\Entity\Customer $customer
     *
     * @return TicketOrder
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
     * @param \Encore\CustomerBundle\Entity\Ticket[] $tickets
     *
     * @return TicketOrder
     */
    public function setTickets($tickets)
    {
        $this->tickets = $tickets;
    }

    /**
     * @return \Encore\CustomerBundle\Entity\Ticket[]
     */
    public function getTickets()
    {
        return $this->tickets;
    }

    /**
     * Set purchaseDate
     *
     * @param \DateTime $purchaseDate
     *
     * @return TicketOrder
     */
    public function setPurchaseDate($purchaseDate)
    {
        $this->purchaseDate = $purchaseDate;

        return $this;
    }

    /**
     * Get purchaseDate
     *
     * @return \DateTime
     */
    public function getPurchaseDate()
    {
        return $this->purchaseDate;
    }

    /**
     * Set totalPaid
     *
     * @param float $totalPaid
     *
     * @return TicketOrder
     */
    public function setTotalPaid($totalPaid)
    {
        $this->totalPaid = $totalPaid;

        return $this;
    }

    /**
     * Get totalPaid
     *
     * @return float
     */
    public function getTotalPaid()
    {
        return $this->totalPaid;
    }

    /**
     * Set secureCardNumber
     *
     * @param \stdClass $billingInfo
     *
     * @return TicketOrder
     */
    public function setSecureCardNumber($billingInfo)
    {
        $this->secureCardNumber = $billingInfo;

        return $this;
    }

    /**
     * Get secureCardNumber
     *
     * @return \stdClass
     */
    public function getSecureCardNumber()
    {
        return $this->secureCardNumber;
    }

}
