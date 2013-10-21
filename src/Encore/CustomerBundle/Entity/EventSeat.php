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
    protected $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer")
     */
    protected $status;

    /**
     * @var \Encore\CustomerBundle\Entity\Seat
     * @ORM\ManyToOne(targetEntity="Encore\CustomerBundle\Entity\Seat", inversedBy="eventSeats")
     * @ORM\JoinColumn(name="seatID", referencedColumnName="id", nullable=false)
     */
    private $seat;

    /**
     * @var \Encore\CustomerBundle\Entity\EventSection
     * @ORM\ManyToOne(targetEntity="Encore\CustomerBundle\Entity\EventSection", inversedBy="eventSeats")
     * @ORM\JoinColumn(name="eventSectionID", referencedColumnName="id", nullable=false)
     */
    private $eventSection;

    /**
     * @var \Encore\CustomerBundle\Entity\Ticket
     * @ORM\OneToOne(targetEntity="Encore\CustomerBundle\Entity\Ticket", mappedBy="eventSeat");
     */
    private $ticket;

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
     * @param \Encore\CustomerBundle\Entity\EventSection $eventSection
     * @return EventSeat
     */
    public function setEventSection($eventSection)
    {
        $this->eventSection = $eventSection;
    }

    /**
     * @return \Encore\CustomerBundle\Entity\EventSection
     */
    public function getEventSection()
    {
        return $this->eventSection;
    }

    /**
     * @param \Encore\CustomerBundle\Entity\Seat $seat
     * @return EventSeat
     */
    public function setSeat($seat)
    {
        $this->seat = $seat;
    }

    /**
     * @return \Encore\CustomerBundle\Entity\Seat
     */
    public function getSeat()
    {
        return $this->seat;
    }

    /**
     * @param \Encore\CustomerBundle\Entity\Ticket $ticket
     * @return EventSeat
     */
    public function setTicket($ticket)
    {
        $this->ticket = $ticket;
        return $this;
    }

    /**
     * @return \Encore\CustomerBundle\Entity\Ticket
     */
    public function getTicket()
    {
        return $this->ticket;
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
