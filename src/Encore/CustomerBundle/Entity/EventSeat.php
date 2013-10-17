<?php

namespace Encore\CustomerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EventSeat
 *
 * @ORM\Table(name="EventSeat")
 * @ORM\Entity(repositoryClass="Encore\CustomerBundle\Repository\EventSeatRepository")
 */
class EventSeat
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
     * @ORM\Column(name="seatID", type="integer")
     */
    private $seatID;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer")
     */
    private $status;


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
     * Set seatID
     *
     * @param integer $seatID
     * @return EventSeat
     */
    public function setSeatID($seatID)
    {
        $this->seatID = $seatID;
    
        return $this;
    }

    /**
     * Get seatID
     *
     * @return integer 
     */
    public function getSeatID()
    {
        return $this->seatID;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return EventSeat
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }
}
