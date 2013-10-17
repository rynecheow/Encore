<?php

namespace Encore\CustomerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TicketOrder
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Encore\CustomerBundle\Entity\TicketOrderRepository")
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
    private $id;

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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
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
}
