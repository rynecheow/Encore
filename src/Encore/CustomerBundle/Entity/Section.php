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
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var \Encore\CustomerBundle\Entity\Venue
     * @ORM\ManyToOne(targetEntity="Encore\CustomerBundle\Entity\Venue", inversedBy="sections")
     * @ORM\JoinColumn(name="venueID", referencedColumnName="id", nullable=false)
     */
    private $venue;

    /**
     * @var \Encore\CustomerBundle\Entity\EventSection[]
     * @ORM\OneToMany(targetEntity="Encore\CustomerBundle\Entity\EventSection", mappedBy="section")
     */
    private $eventSection;

    /**
     * @var \Encore\CustomerBundle\Entity\Seat[]
     * @ORM\OneToMany(targetEntity="Encore\CustomerBundle\Entity\Seat", mappedBy="section")
     */
    private $seats;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=200)
     */
    protected $name;

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
     *
     * @return Section
     */
    public function setVenue($venue)
    {
        $this->venue = $venue;

        return $this;
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
     *
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

    /**
     * @param \Encore\CustomerBundle\Entity\Seat[] $seats
     *
     * @return $this
     */
    public function setSeats($seats)
    {
        $this->seats = $seats;

        return $this;
    }

    /**
     * @return \Encore\CustomerBundle\Entity\Seat[]
     */
    public function getSeats()
    {
        return $this->seats;
    }
}
