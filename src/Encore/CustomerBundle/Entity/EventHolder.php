<?php

namespace Encore\CustomerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EventHolder
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Encore\CustomerBundle\Repository\EventHolderRepository")
 */
class EventHolder
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
     * @var \Encore\CustomerBundle\Entity\Event
     * @ORM\ManyToOne(targetEntity="Encore\CustomerBundle\Entity\Event", inversedBy="eventHolders")
     * @ORM\JoinColumn(name="eventID", referencedColumnName="id", nullable=false)
     */
    private $event;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="heldDate", type="datetime")
     */
    protected $heldDate;

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
     * @param \Encore\CustomerBundle\Entity\Event $event
     *
     * @return $this
     */
    public function setEvent($event)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * @return \Encore\CustomerBundle\Entity\Event
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @param \DateTime $heldDate
     *
     * @return $this
     */
    public function setHeldDate($heldDate)
    {
        $this->heldDate = $heldDate;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getHeldDate()
    {
        return $this->heldDate;
    }
}
