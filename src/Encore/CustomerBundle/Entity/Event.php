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
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var \Encore\CustomerBundle\Entity\Venue
     * @ORM\ManyToOne(targetEntity="Encore\CustomerBundle\Entity\Venue", inversedBy="events")
     * @ORM\JoinColumn(name="venueID", referencedColumnName="id")
     */
    private $venue;


    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=200)
     */
    protected $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="type", type="integer")
     */
    protected $type;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    protected $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createAt", type="datetime")
     */
    protected $createAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="saleStart", type="datetime")
     */
    protected $saleStart;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="saleEnd", type="datetime")
     */
    protected $saleEnd;

    /**
     * @var \array
     *
     * @ORM\Column(name="heldDates", type="datetime")
     */
    protected $heldDates;

    /**
     * @var integer
     *
     * @ORM\Column(name="totalTickets", type="integer")
     */
    protected $totalTickets;


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
     * @param \Encore\CustomerBundle\Entity\Venue $venue
     */
    public function setVenue($venue)
    {
        $this->venue = $venue;
    }

    /**
     * @return \Encore\CustomerBundle\Entity\Venue
     */
    public function getVenue()
    {
        return $this->venue;
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
