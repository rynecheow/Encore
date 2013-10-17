<?php

namespace Encore\CustomerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Merchant
 *
 * @ORM\Table(name="Merchant")
 * @ORM\Entity(repositoryClass="Encore\CustomerBundle\Repository\MerchantRepository")
 */
class Merchant
{
    /**
     * @var integer
     *
     * @ORM\Column(name="merchantID", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $merchantID;

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
     * Get merchantID
     *
     * @return integer 
     */
    public function getMerchantID()
    {
        return $this->merchantID;
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
