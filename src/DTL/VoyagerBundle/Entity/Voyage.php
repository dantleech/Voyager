<?php

namespace DTL\VoyagerBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Voyage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Place")
     */
    protected $depart;

    /**
     * @ORM\ManyToOne(targetEntity="Place")
     */
    protected $arrive;

    /**
     * @ORM\ManyToOne(targetEntity="Tour")
     */
    protected $tour;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $date;

    /**
     * @ORM\Column(type="text")
     */
    protected $log;

    /**
     * Distance in meters
     *
     * @ORM\Column(type="integer")
     */
    protected $distance;

    /**
     * Time in seconds
     *
     * @ORM\Column(type="integer")
     */
    protected $time;

    /**
     * Max speed in meters per hour
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $maxSpeed;

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
     * Set depart
     *
     * @param string $depart
     */
    public function setDepart($depart)
    {
        $this->depart = $depart;
    }

    /**
     * Get depart
     *
     * @return string 
     */
    public function getDepart()
    {
        return $this->depart;
    }

    /**
     * Set arrive
     *
     * @param string $arrive
     */
    public function setArrive($arrive)
    {
        $this->arrive = $arrive;
    }

    /**
     * Get arrive
     *
     * @return string 
     */
    public function getArrive()
    {
        return $this->arrive;
    }

    /**
     * Set date
     *
     * @param datetime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * Get date
     *
     * @return datetime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set log
     *
     * @param text $log
     */
    public function setLog($log)
    {
        $this->log = $log;
    }

    /**
     * Get log
     *
     * @return text 
     */
    public function getLog()
    {
        return $this->log;
    }

    /**
     * Set distance
     *
     * @param integer $distance
     */
    public function setDistance($distance)
    {
        $this->distance = $distance;
    }

    /**
     * Get distance
     *
     * @return integer 
     */
    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * Set time
     *
     * @param integer $time
     */
    public function setTime($time)
    {
        $this->time = $time;
    }

    /**
     * Get time
     *
     * @return integer 
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set maxSpeed
     *
     * @param integer $maxSpeed
     */
    public function setMaxSpeed($maxSpeed)
    {
        $this->maxSpeed = $maxSpeed;
    }

    /**
     * Get maxSpeed
     *
     * @return integer 
     */
    public function getMaxSpeed()
    {
        return $this->maxSpeed;
    }

    /**
     * Set tour
     *
     * @param DTL\VoyagerBundle\Entity\DTLVoyagerBundle:Tour $tour
     */
    public function setTour(\DTL\VoyagerBundle\Entity\Tour $tour)
    {
        $this->tour = $tour;
    }

    /**
     * Get tour
     *
     * @return DTL\VoyagerBundle\Entity\DTLVoyagerBundle:Tour 
     */
    public function getTour()
    {
        return $this->tour;
    }
}
