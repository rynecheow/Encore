<?php

namespace Encore\CustomerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Merchant
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Encore\CustomerBundle\Entity\MerchantRepository")
 */
class Merchant
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
     * @ORM\Column(name="username", type="string", length=200)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="merchantName", type="string", length=255)
     */
    private $merchantName;


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
     * Set username
     *
     * @param string $username
     * @return Merchant
     */
    public function setUsername($username)
    {
        $this->username = $username;
    
        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set merchantName
     *
     * @param string $merchantName
     * @return Merchant
     */
    public function setMerchantName($merchantName)
    {
        $this->merchantName = $merchantName;
    
        return $this;
    }

    /**
     * Get merchantName
     *
     * @return string 
     */
    public function getMerchantName()
    {
        return $this->merchantName;
    }
}
