<?php

namespace Encore\CustomerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CustomerOrder
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Encore\CustomerBundle\Entity\CustomerOrderRepository")
 */
class CustomerOrder
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
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
