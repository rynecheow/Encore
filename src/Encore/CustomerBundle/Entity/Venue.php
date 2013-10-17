<?php

namespace Encore\CustomerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Venue
 *
 * @ORM\Table(name="Venue")
 * @ORM\Entity(repositoryClass="Encore\CustomerBundle\Repository\VenueRepository")
 */
class Venue
{
    /**
     * @var integer
     *
     * @ORM\Column(name="venueID", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $venueID;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=200)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="location", type="string", length=200)
     */
    private $location;


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
     * @return Venue
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
     * Set location
     *
     * @param string $location
     * @return Venue
     */
    public function setLocation($location)
    {
        $this->location = $location;
    
        return $this;
    }

    /**
     * Get location
     *
     * @return string 
     */
    public function getLocation()
    {
        return $this->location;
    }
}
