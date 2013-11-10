<?php

namespace Encore\CustomerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Event
 *
 * @ORM\Table(name="Event")
 * @ORM\Entity(repositoryClass="Encore\CustomerBundle\Repository\EventRepository")
 *
 * @Vich\Uploadable
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
     * @ORM\JoinColumn(name="venueID", referencedColumnName="id", nullable=false)
     */
    private $venue;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=200)
     */
    protected $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $featuredAt;

    /**
     * @var integer
     *
     * @ORM\Column(name="type", type="integer")
     */
    protected $type;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
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
     * @var \Encore\CustomerBundle\Entity\EventHolder[]
     * @ORM\OneToMany(targetEntity="Encore\CustomerBundle\Entity\EventHolder", mappedBy="event")
     */
    private $eventHolders;

    /**
     * @var boolean
     *
     * @ORM\Column(name="publish", type="boolean")
     */
    protected $publish;

    /**
     * @var \Encore\CustomerBundle\Entity\Merchant
     * @ORM\ManyToOne(targetEntity="Encore\CustomerBundle\Entity\Merchant", inversedBy="events")
     * @ORM\JoinColumn(name="merchantID", referencedColumnName="id", nullable=false)
     */

    private $creator;

    /**
     * @var \Encore\CustomerBundle\Entity\EventPhoto[]
     *
     * @ORM\OneToMany(targetEntity="\Encore\CustomerBundle\Entity\EventPhoto", mappedBy="event", cascade={"persist"})
     */
    private $photos;

    /**
     * @var array
     *
     * @ORM\Column(name="photo_sequence", type="array", nullable=true)
     */
    private $photoSequence = [];

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
     * @param \DateTime $featuredAt
     */
    public function setFeaturedAt($featuredAt)
    {
        $this->featuredAt = $featuredAt;
    }

    /**
     * @return \DateTime
     */
    public function getFeaturedAt()
    {
        return $this->featuredAt;
    }

    /**
     * @param \Encore\CustomerBundle\Entity\Merchant $creator
     *
     * @return Event
     */
    public function setCreator($creator)
    {
        $this->creator = $creator;

        return $this;
    }

    /**
     * @return \Encore\CustomerBundle\Entity\Merchant
     */
    public function getCreator()
    {
        return $this->creator;
    }

    /**
     * @param \Encore\CustomerBundle\Entity\Venue $venue
     *
     * @return Event
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
     *
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
     *
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
     *
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
     *
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
     *
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
     * Set totalTickets
     *
     * @param integer $totalTickets
     *
     * @return Event
     */
    public function setTotalTickets($totalTickets)
    {
        $this->totalTickets = $totalTickets;

        return $this;
    }

    /**
     * Add photo
     *
     * @param \Encore\CustomerBundle\Entity\EventPhoto $photo
     *
     * @return Event
     */
    public function addPhoto(EventPhoto $photo)
    {
        $this->photos[] = $photo;
        $this->photoSequence[] = $photo->getId();

        return $this;
    }

    /**
     * Remove photo
     *
     * @param \Encore\CustomerBundle\Entity\EventPhoto $photo
     */
    public function removePhoto(EventPhoto $photo)
    {
        foreach ($this->photoSequence as $key => $photoId) {
            if ($photoId == $photo->getId()) {
                unset($this->photoSequence[$key]);
                break;
            }
        }
        $this->photos->removeElement($photo);

    }

    /**
     * Get photos
     *
     * @return \Encore\CustomerBundle\Entity\EventPhoto[]
     */
    public function getPhotos()
    {
        return $this->photos;
    }

    /**
     * Set photoSequence
     *
     * @param array $photoSequence
     *
     * @return Event
     */
    public function setPhotoSequence(array $photoSequence)
    {
        $this->photoSequence = $photoSequence;

        return $this;
    }

    /**
     * Get photoSequence
     *
     * @return array
     */
    public function getPhotoSequence()
    {
        return $this->photoSequence;
    }

    /**
     * @param boolean $publish
     *
     * @return $this
     */
    public function setPublish($publish)
    {
        $this->publish = $publish;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getPublish()
    {
        return $this->publish;
    }

    /**
     * @param \Encore\CustomerBundle\Entity\EventHolder[] $eventHolders
     *
     * @return $this
     */
    public function setEventHolders($eventHolders)
    {
        $this->eventHolders = $eventHolders;

        return $this;
    }

    /**
     * @return \Encore\CustomerBundle\Entity\EventHolder[]
     */
    public function getEventHolders()
    {
        return $this->eventHolders;
    }

}
