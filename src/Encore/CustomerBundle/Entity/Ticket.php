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
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="seatName", type="string", length=200)
     */
    protected $seatName;

    /**
     * @var string
     *
     * @ORM\Column(name="eventName", type="string", length=200)
     */
    protected $eventName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="eventDate", type="datetime")
     */
    protected $eventDate;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="decimal")
     */
    protected $price;

    /**
     * @var string
     *
     * @ORM\Column(name="serialNumber", type="string", length=255)
     */
    protected $serialNumber;

    /**
     * @var \Encore\CustomerBundle\Entity\EventSeat
     * @ORM\OneToOne(targetEntity="Encore\CustomerBundle\Entity\EventSeat", inversedBy="ticket")
     * @ORM\JoinColumn(name="eventSeatID", referencedColumnName="id", nullable=false)
     */
    private $eventSeat;

    /**
     * @var \Encore\CustomerBundle\Entity\TicketOrder
     * @ORM\ManyToOne(targetEntity="Encore\CustomerBundle\Entity\TicketOrder", inversedBy="tickets")
     * @ORM\JoinColumn(name="ticketOrderID", referencedColumnName="id", nullable=false)
     */
    private $ticketOrder;
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
     * @param \DateTime $eventDate
     *
     * @return Ticket
     */
    public function setEventDate($eventDate)
    {
        $this->eventDate = $eventDate;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getEventDate()
    {
        return $this->eventDate;
    }

    /**
     * @param string $eventName
     *
     * @return Ticket
     */
    public function setEventName($eventName)
    {
        $this->eventName = $eventName;
        return $this;
    }

    /**
     * @return string
     */
    public function getEventName()
    {
        return $this->eventName;
    }

    /**
     * @param \Encore\CustomerBundle\Entity\EventSeat $eventSeat
     *
     * @return Ticket
     */
    public function setEventSeat($eventSeat)
    {
        $this->eventSeat = $eventSeat;
        return $this;
    }

    /**
     * @return \Encore\CustomerBundle\Entity\EventSeat
     */
    public function getEventSeat()
    {
        return $this->eventSeat;
    }

    /**
     * @param float $price
     *
     * @return Ticket
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param string $seatName
     *
     * @return Ticket
     */
    public function setSeatName($seatName)
    {
        $this->seatName = $seatName;
        return $this;
    }

    /**
     * @return string
     */
    public function getSeatName()
    {
        return $this->seatName;
    }

    /**
     * @param string $serialNumber
     *
     * @return Ticket
     */
    public function setSerialNumber($serialNumber)
    {
        $this->serialNumber = $serialNumber;
        return $this;
    }

    /**
     * @return string
     */
    public function getSerialNumber()
    {
        return $this->serialNumber;
    }

    /**
     * @param \Encore\CustomerBundle\Entity\TicketOrder $ticketOrder
     *
     * @return Ticket
     */
    public function setTicketOrder($ticketOrder)
    {
        $this->ticketOrder = $ticketOrder;
        return $this;
    }

    /**
     * @return \Encore\CustomerBundle\Entity\TicketOrder
     */
    public function getTicketOrder()
    {
        return $this->ticketOrder;
    }


}