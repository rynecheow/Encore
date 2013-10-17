<?php

namespace Encore\CustomerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Event
 *
 * @ORM\Table(name="Event")
 * @ORM\Entity(repositoryClass="Encore\CustomerBundle\Repository\EventRepository")
 */
class Event
{
    /**
     * @var integer
     *
     * @ORM\Column(name="eventID", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $eventID;

    /**
     * @var integer
     *
     * @ORM\Column(name="venueID", type="integer")
     */
    private $venueID;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=200)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="type", type="integer")
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createAt", type="datetime")
     */
    private $createAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="saleStart", type="datetime")
     */
    private $saleStart;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="saleEnd", type="datetime")
     */
    private $saleEnd;

    /**
     * @var \array
     *
     * @ORM\Column(name="heldDates", type="datetime")
     */
    private $heldDates;

    /**
     * @var integer
     *
     * @ORM\Column(name="totalTickets", type="integer")
     */
    private $totalTickets;


    /**
     * Get eventID
     *
     * @return integer 
     */
    public function getEventID()
    {
        return $this->eventID;
    }

    /**
     * Set venueID
     *
     * @param integer $venueID
     * @return Event
     */
    public function setVenueID($venueID)
    {
        $this->venueID = $venueID;
    
        return $this;
    }

    /**
     * Get venueID
     *
     * @return integer 
     */
    public function getVenueID()
    {
        return $this->venueID;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Event
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set type
     *
     * @param integer $type
     * @return Event
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return integer 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Event
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set createAt
     *
     * @param \DateTime $createAt
     * @return Event
     */
    public function setCreateAt($createAt)
    {
        $this->createAt = $createAt;
    
        return $this;
    }

    /**
     * Get createAt
     *
     * @return \DateTime 
     */
    public function getCreateAt()
    {
        return $this->createAt;
    }

    /**
     * Set saleStart
     *
     * @param \DateTime $saleStart
     * @return Event
     */
    public function setSaleStart($saleStart)
    {
        $this->saleStart = $saleStart;
    
        return $this;
    }

    /**
     * Get saleStart
     *
     * @return \DateTime 
     */
    public function getSaleStart()
    {
        return $this->saleStart;
    }

    /**
     * Set saleEnd
     *
     * @param \DateTime $saleEnd
     * @return Event
     */
    public function setSaleEnd($saleEnd)
    {
        $this->saleEnd = $saleEnd;
    
        return $this;
    }

    /**
     * Get saleEnd
     *
     * @return \DateTime 
     */
    public function getSaleEnd()
    {
        return $this->saleEnd;
    }

    /**
     * Set heldDates
     *
     * @param \array $heldDate
     * @return Event
     */
    public function setHeldDates($heldDate)
    {
        $this->heldDates = $heldDate;
    
        return $this;
    }

    /**
     * Get heldDates
     *
     * @return \array
     */
    public function getHeldDates()
    {
        return $this->heldDates;
    }

    /**
     * Set totalTickets
     *
     * @param integer $totalTickets
     * @return Event
     */
    public function setTotalTickets($totalTickets)
    {
        $this->totalTickets = $totalTickets;
    
        return $this;
    }

    /**
     * Get totalTickets
     *
     * @return integer 
     */
    public function getTotalTickets()
    {
        return $this->totalTickets;
    }
}
