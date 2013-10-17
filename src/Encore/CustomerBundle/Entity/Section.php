<?php

namespace Encore\CustomerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Section
 *
 * @ORM\Table(name="Section")
 * @ORM\Entity(repositoryClass="Encore\CustomerBundle\Repository\SectionRepository")
 */
class Section
{
    /**
     * @var integer
     *
     * @ORM\Column(name="sectionID", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $sectionID;

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
     * Get sectionID
     *
     * @return integer 
     */
    public function getSectionID()
    {
        return $this->sectionID;
    }

    /**
     * Set venueID
     *
     * @param integer $venueID
     * @return Section
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
     * @return Section
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
}
