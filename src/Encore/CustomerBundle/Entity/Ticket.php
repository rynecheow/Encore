<?php

namespace Encore\CustomerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ticket
 *
 * @ORM\Table(name="Ticket")
 * @ORM\Entity(repositoryClass="Encore\CustomerBundle\Repository\TicketRepository")
 */
class Ticket
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
     * @ORM\Column(name="eventID", type="integer")
     */
    private $eventID;


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
     * @return Ticket
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
     * Set eventID
     *
     * @param integer $eventID
     * @return Ticket
     */
    public function setEventID($eventID)
    {
        $this->eventID = $eventID;
    
        return $this;
    }

    /**
     * Get eventID
     *
     * @return integer 
     */
    public function getEventID()
    {
        return $this->eventID;
    }
}
