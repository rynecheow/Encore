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
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="eventID", type="integer")
     */
    private $eventID;

    /**
     * @var integer
     *
     * @ORM\Column(name="sectionID", type="integer")
     */
    private $sectionID;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="decimal")
     */
    private $price;

    /**
     * @var integer
     *
     * @ORM\Column(name="totalSeats", type="integer")
     */
    private $totalSeats;

    /**
     * @var integer
     *
     * @ORM\Column(name="totalSold", type="integer")
     */
    private $totalSold;


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
     * Set eventID
     *
     * @param integer $eventID
     * @return EventSection
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

    /**
     * Set sectionID
     *
     * @param integer $sectionID
     * @return EventSection
     */
    public function setSectionID($sectionID)
    {
        $this->sectionID = $sectionID;
    
        return $this;
    }

    /**
     * Get sectionID
     *
     * @return integer 
     */
    public function getSectionID()
    {
        return $this->sectionID;
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
