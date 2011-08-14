<?php

namespace DTL\VoyagerBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Place
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\Column(type="decimal", scale=4, nullable=true)
     */
    protected $coordLong;

    /**
     * @ORM\Column(type="decimal", scale=4, nullable=true)
     */
    protected $coordLat;

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
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
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
     * Set coordLong
     *
     * @param decimal $coordLong
     */
    public function setCoordLong($coordLong)
    {
        $this->coordLong = $coordLong;
    }

    /**
     * Get coordLong
     *
     * @return decimal 
     */
    public function getCoordLong()
    {
        return $this->coordLong;
    }

    /**
     * Set coordLat
     *
     * @param decimal $coordLat
     */
    public function setCoordLat($coordLat)
    {
        $this->coordLat = $coordLat;
    }

    /**
     * Get coordLat
     *
     * @return decimal 
     */
    public function getCoordLat()
    {
        return $this->coordLat;
    }
}
