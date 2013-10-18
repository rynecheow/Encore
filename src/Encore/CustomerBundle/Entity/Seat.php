<?php

namespace Encore\CustomerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Seat
 *
 * @ORM\Table(name="Seat")
 * @ORM\Entity(repositoryClass="Encore\CustomerBundle\Repository\SeatRepository")
 */
class Seat
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
     * @ORM\Column(name="row", type="string", length=10)
     */
    protected $row;

    /**
     * @var string
     *
     * @ORM\Column(name="col", type="string", length=10)
     */
    protected $col;

    /**
     * @var string
     *
     * @ORM\Column(name="seatName", type="string", length=100)
     */
    protected $seatName;

    /**
     * @var \Encore\CustomerBundle\Entity\Section
     * @ORM\ManyToOne(targetEntity="Encore\CustomerBundle\Entity\Section", inversedBy="seats")
     * @ORM\JoinColumn(name="sectionID", referencedColumnName="id", nullable=false)
     */
    private $section;


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
     * Set row
     *
     * @param string $row
     * @return Seat
     */
    public function setRow($row)
    {
        $this->row = $row;
    
        return $this;
    }

    /**
     * Get row
     *
     * @return string 
     */
    public function getRow()
    {
        return $this->row;
    }

    /**
     * Set col
     *
     * @param string $col
     * @return Seat
     */
    public function setCol($col)
    {
        $this->col = $col;
    
        return $this;
    }

    /**
     * Get col
     *
     * @return string 
     */
    public function getCol()
    {
        return $this->col;
    }

    /**
     * Set seatName
     *
     * @param string $seatName
     * @return Seat
     */
    public function setSeatName($seatName)
    {
        $this->seatName = $seatName;
    
        return $this;
    }

    /**
     * Get seatName
     *
     * @return string 
     */
    public function getSeatName()
    {
        return $this->seatName;
    }

    /**
     * @param \Encore\CustomerBundle\Entity\Section $section
     */
    public function setSection($section)
    {
        $this->section = $section;
    }

    /**
     * @return \Encore\CustomerBundle\Entity\Section
     */
    public function getSection()
    {
        return $this->section;
    }
}
