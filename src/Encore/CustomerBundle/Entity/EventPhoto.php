<?php

namespace Encore\CustomerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * EventPhoto
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Encore\CustomerBundle\Repository\EventPhotoRepository")
 */
class EventPhoto
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
     * @ORM\Column(name="imagePath", type="text", nullable=false)
     */
    private $imagePath;

    /**
     * @var File $image
     * @Assert\File(
     *     maxSize="1M",
     *     mimeTypes={"image/png", "image/jpeg"}
     * )
     * @Vich\UploadableField(mapping="product", fileNameProperty="imagePath")
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="caption", type="text")
     */
    private $caption;

    /**
     * @var \Encore\CustomerBundle\Entity\Event
     *
     * @ORM\ManyToOne(targetEntity="Encore\CustomerBundle\Entity\Event", inversedBy="photos")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $event;

    public function __clone()
    {
        // Doctrine-safe guard
        if ($this->id) {
            $this->id = null;
        }
    }

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
     * Set imagePath
     *
     * @param string $imagePath
     * @return EventPhoto
     */
    public function setImagePath($imagePath)
    {
        $this->imagePath = $imagePath;

        return $this;
    }

    /**
     * Get imagePath
     *
     * @return string
     */
    public function getImagePath()
    {
        return $this->imagePath;
    }

    /**
     * Set image
     *
     * @param File $image
     * @return EventPhoto
     */
    public function setImage(File $image)
    {
        $this->image = $image;

        // workaround to always trigger update
        if ($image) {
            $this->imagePath = $image->getFileName();
        }

        return $this;
    }

    /**
     * Get image
     *
     * @return File
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set caption
     *
     * @param string $caption
     * @return EventPhoto
     */
    public function setCaption($caption)
    {
        $this->caption = $caption;

        return $this;
    }

    /**
     * Get caption
     *
     * @return string
     */
    public function getCaption()
    {
        return $this->caption;
    }

    /**
     * Set product
     *
     * @param \Encore\CustomerBundle\Entity\Event $product
     * @return EventPhoto
     */
    public function setEvent(Event $product)
    {
        $this->event = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \Encore\CustomerBundle\Entity\Event
     */
    public function getEvent()
    {
        return $this->event;
    }
}
