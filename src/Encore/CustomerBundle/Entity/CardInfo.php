<?php

namespace Encore\CustomerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CardInfo
 *
 * @ORM\Table(name="CardInformation")
 * @ORM\Entity(repositoryClass="Encore\CustomerBundle\Repository\CardInfoRepository")
 */
class CardInfo
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
     * @var integer
     *
     * @ORM\Column(name="type", type="integer")
     */
    protected $type;

    /**
     * @var string
     *
     * @ORM\Column(name="cardNum", type="string", length=20)
     */
    protected $cardNum;

    /**
     * @var string
     *
     * @ORM\Column(name="secureNum", type="string", length=10)
     */
    protected $secureNum;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="expireAt", type="datetime")
     */
    protected $expireAt;


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
     * Set type
     *
     * @param integer $type
     * @return CardInfo
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
     * Set cardNum
     *
     * @param string $cardNum
     * @return CardInfo
     */
    public function setCardNum($cardNum)
    {
        $this->cardNum = $cardNum;
    
        return $this;
    }

    /**
     * Get cardNum
     *
     * @return string 
     */
    public function getCardNum()
    {
        return $this->cardNum;
    }

    /**
     * Set secureNum
     *
     * @param string $secureNum
     * @return CardInfo
     */
    public function setSecureNum($secureNum)
    {
        $this->secureNum = $secureNum;
    
        return $this;
    }

    /**
     * Get secureNum
     *
     * @return string 
     */
    public function getSecureNum()
    {
        return $this->secureNum;
    }

    /**
     * Set expireAt
     *
     * @param \DateTime $expireAt
     * @return CardInfo
     */
    public function setExpireAt($expireAt)
    {
        $this->expireAt = $expireAt;
    
        return $this;
    }

    /**
     * Get expireAt
     *
     * @return \DateTime 
     */
    public function getExpireAt()
    {
        return $this->expireAt;
    }
}
