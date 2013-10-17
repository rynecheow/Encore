<?php

namespace Encore\CustomerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CustomerOrder
 *
 * @ORM\Table(name="CustomerOrder")
 * @ORM\Entity(repositoryClass="Encore\CustomerBundle\Repository\CustomerOrderRepository")
 */
class CustomerOrder
{
    /**
     * @var integer
     *
     * @ORM\Column(name="customerOrderID", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $customerOrderID;

    /**
     * @var integer
     *
     * @ORM\Column(name="customerID", type="integer")
     */
    private $customerID;

    /**
     * @var integer
     *
     * @ORM\Column(name="orderID", type="integer")
     */
    private $orderID;


    /**
     * Get customerOrderID
     *
     * @return integer 
     */
    public function getCustomerOrderID()
    {
        return $this->customerOrderID;
    }

    /**
     * Set customerID
     *
     * @param integer $customerID
     * @return CustomerOrder
     */
    public function setCustomerID($customerID)
    {
        $this->customerID = $customerID;
    
        return $this;
    }

    /**
     * Get customerID
     *
     * @return integer 
     */
    public function getCustomerID()
    {
        return $this->customerID;
    }

    /**
     * Set orderID
     *
     * @param integer $orderID
     * @return CustomerOrder
     */
    public function setOrderID($orderID)
    {
        $this->orderID = $orderID;
    
        return $this;
    }

    /**
     * Get orderID
     *
     * @return integer 
     */
    public function getOrderID()
    {
        return $this->orderID;
    }
}
