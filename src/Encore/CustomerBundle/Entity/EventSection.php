<?php

namespace Encore\CustomerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EventSection
 *
 * @ORM\Table(name="EventSection")
 * @ORM\Entity(repositoryClass="Encore\CustomerBundle\Entity\EventSectionRepository")
 */
class EventSection
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
     * @var \Encore\CustomerBundle\Entity\Event
     * @ORM\ManyToOne(targetEntity="Encore\CustomerBundle\Entity\Event", inversedBy="eventSections")
     * @ORM\JoinColumn(name="eventID", referencedColumnName="id", nullable=false)
     */
    private $event;

    /**
     * @var \Encore\CustomerBundle\Entity\Section
     * @ORM\ManyToOne(targetEntity="Encore\CustomerBundle\Entity\Section", inversedBy="eventSections")
     * @ORM\JoinColumn(name="sectionID", referencedColumnName="id", nullable=false)
     */
    private $section;

    /**
     * @var \Encore\CustomerBundle\Entity\EventSeat
     * @ORM\OneToMany(targetEntity="Encore\CustomerBundle\Entity\EventSeat", mappedBy="eventSection")
     */
    private $eventSeats;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="decimal")
     */
    protected $price;

    /**
     * @var integer
     *
     * @ORM\Column(name="totalSeats", type="integer")
     */
    protected $totalSeats;

    /**
     * @var integer
     *
     * @ORM\Column(name="totalSold", type="integer")
     */
    protected $totalSold;


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
     * @param \Encore\CustomerBundle\Entity\Event $event
     *
     * @return EventSection
     */
    public function setEvent($event)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * @return \Encore\CustomerBundle\Entity\Event
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @param \Encore\CustomerBundle\Entity\Section $section
     *
     * @return EventSection
     */
    public function setSection($section)
    {
        $this->section = $section;

        return $this;
    }

    /**
     * @return \Encore\CustomerBundle\Entity\Section
     */
    public function getSection()
    {
        return $this->section;
    }

    /**
     * @param \Encore\CustomerBundle\Entity\EventSeat $eventSeats
     * @return EventSection
     */
    public function setEventSeats($eventSeats)
    {
        $this->eventSeats = $eventSeats;
        return $this;
    }

    /**
     * @return \Encore\CustomerBundle\Entity\EventSeat
     */
    public function getEventSeats()
    {
        return $this->eventSeats;
    }
    /**
     * Set price
     *
     * @param float $price
     * @return EventSection
     */
    public function setPrice($price)
    {
        $this->price = $price;
    
        return $this;
    }

    /**
     * Get price
     *
     * @return float 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set totalSeats
     *
     * @param integer $totalSeats
     * @return EventSection
     */
    public function setTotalSeats($totalSeats)
    {
        $this->totalSeats = $totalSeats;
    
        return $this;
    }

    /**
     * Get totalSeats
     *
     * @return integer 
     */
    public function getTotalSeats()
    {
        return $this->totalSeats;
    }

    /**
     * Set totalSold
     *
     * @param integer $totalSold
     * @return EventSection
     */
    public function setTotalSold($totalSold)
    {
        $this->totalSold = $totalSold;
    
        return $this;
    }

    /**
     * Get totalSold
     *
     * @return integer 
     */
    public function getTotalSold()
    {
        return $this->totalSold;
    }
}
