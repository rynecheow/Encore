<?php

namespace Encore\CustomerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Customer
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Encore\CustomerBundle\Entity\CustomerRepository")
 */
class Customer
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
     * @ORM\Column(name="firstName", type="string", length=200)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="laststName", type="string", length=200)
     */
    private $laststName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthDate", type="datetime")
     */
    private $birthDate;

    /**
     * @var string
     *
     * @ORM\Column(name="contactNo", type="string", length=200)
     */
    private $contactNo;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=200)
     */
    private $address;


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
     * @return Customer
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
     * Set firstName
     *
     * @param string $firstName
     * @return Customer
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    
        return $this;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set laststName
     *
     * @param string $laststName
     * @return Customer
     */
    public function setLaststName($laststName)
    {
        $this->laststName = $laststName;
    
        return $this;
    }

    /**
     * Get laststName
     *
     * @return string 
     */
    public function getLaststName()
    {
        return $this->laststName;
    }

    /**
     * Set birthDate
     *
     * @param \DateTime $birthDate
     * @return Customer
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;
    
        return $this;
    }

    /**
     * Get birthDate
     *
     * @return \DateTime 
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * Set contactNo
     *
     * @param string $contactNo
     * @return Customer
     */
    public function setContactNo($contactNo)
    {
        $this->contactNo = $contactNo;
    
        return $this;
    }

    /**
     * Get contactNo
     *
     * @return string 
     */
    public function getContactNo()
    {
        return $this->contactNo;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return Customer
     */
    public function setAddress($address)
    {
        $this->address = $address;
    
        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }
}
