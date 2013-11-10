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
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=200)
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(name="location", type="string", length=200)
     */
    protected $location;

    /**
     * @var \Encore\CustomerBundle\Entity\Event
     * @ORM\OneToMany(targetEntity="Encore\CustomerBundle\Entity\Event", mappedBy="venue")
     */

    private $events;

    /**
     * @var \Encore\CustomerBundle\Entity\Section[]
     * @ORM\OneToMany(targetEntity="Encore\CustomerBundle\Entity\Section", mappedBy="venue")
     */

    private $sections;

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
     * @param \Encore\CustomerBundle\Entity\Event $events
     *
     * @return Venue
     */
    public function setEvents($events)
    {
        $this->events = $events;

        return $this;
    }

    /**
     * @return \Encore\CustomerBundle\Entity\Event
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * @param \Encore\CustomerBundle\Entity\Section[] $sections
     *
     * @return Venue
     */
    public function setSections($sections)
    {
        $this->sections = $sections;

        return $this;
    }

    /**
     * @return \Encore\CustomerBundle\Entity\Section[]
     */
    public function getSections()
    {
        return $this->sections;
    }

    /**
     * Set name
     *
     * @param string $name
     *
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
     *
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
