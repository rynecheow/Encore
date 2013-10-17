<?php

namespace Encore\CustomerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Seat
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Encore\CustomerBundle\Entity\SeatRepository")
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
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="row", type="string", length=10)
     */
    private $row;

    /**
     * @var string
     *
     * @ORM\Column(name="col", type="string", length=10)
     */
    private $col;

    /**
     * @var string
     *
     * @ORM\Column(name="seatName", type="string", length=100)
     */
    private $seatName;

    /**
     * @var integer
     *
     * @ORM\Column(name="sectionID", type="integer")
     */
    private $sectionID;


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
     * Set sectionID
     *
     * @param integer $sectionID
     * @return Seat
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
}
