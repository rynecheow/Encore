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
     * @ORM\Column(name="ticketOrderID", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $ticketOrderID;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="purchaseDate", type="datetime")
     */
    private $purchaseDate;

    /**
     * @var float
     *
     * @ORM\Column(name="totalAmount", type="decimal")
     */
    private $totalAmount;

    /**
     * @var \stdClass
     *
     * @ORM\Column(name="billingInfo", type="object")
     */
    private $billingInfo;

    /**
     * @var array
     *
     * @ORM\Column(name="ticketIDs", type="array")
     */
    private $ticketIDs;

    /**
     * Get ticketOrderID
     *
     * @return integer 
     */
    public function getTicketOrderID()
    {
        return $this->ticketOrderID;
    }

    /**
     * Set purchaseDate
     *
     * @param \DateTime $purchaseDate
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
     * Set totalAmount
     *
     * @param float $totalAmount
     * @return TicketOrder
     */
    public function setTotalAmount($totalAmount)
    {
        $this->totalAmount = $totalAmount;
    
        return $this;
    }

    /**
     * Get totalAmount
     *
     * @return float 
     */
    public function getTotalAmount()
    {
        return $this->totalAmount;
    }

    /**
     * Set billingInfo
     *
     * @param \stdClass $billingInfo
     * @return TicketOrder
     */
    public function setBillingInfo($billingInfo)
    {
        $this->billingInfo = $billingInfo;
    
        return $this;
    }

    /**
     * Get billingInfo
     *
     * @return \stdClass 
     */
    public function getBillingInfo()
    {
        return $this->billingInfo;
    }

    /**
     * Set ticketIDs
     *
     * @param array $ticketIDs
     * @return Seat
     */
    public function setTicketIDs($ticketIDs)
    {
        $this->ticketIDs = $ticketIDs;

        return $this;
    }

    /**
     * Get ticketIDs
     *
     * @return array
     */
    public function getTicketIDs()
    {
        return $this->ticketIDs;
    }
}
