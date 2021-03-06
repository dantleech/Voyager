<?php

namespace DTL\VoyagerBundle\Document;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use DTL\TrainerBundle\Util\DocumentUtil;

/**
 * @MongoDB\Document(repositoryClass="DTL\VoyagerBundle\Repository\StageRepository")
 */
class Stage
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\ReferenceOne(targetDocument="Tour")
     */
    protected $tour;

    /**
     * @MongoDB\String
     */
    protected $title;

    /**
     * @MongoDB\String
     */
    protected $description;

    /**
     * @MongoDB\Date
     */
    protected $startDate;

    /**
     * Not persisted, calculated at runtime based
     * on next stage
     */
    protected $endDate;

    protected $days;

    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Get title
     *
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get description
     *
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }

    public function setStartDate($date)
    {
        $this->startDate = $date;
    }

    public function getStartDate()
    {
        // normalize start date
        $this->startDate->modify('midnight');
        return $this->startDate;
    }
    
    /**
     * Set tour
     *
     * @param string $tour
     */
    public function setTour($tour)
    {
        $this->tour = $tour;
    }

    /**
     * Get tour
     *
     * @return string $tour
     */
    public function getTour()
    {
        return $this->tour;
    }

    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
    }

    public function getEndDate()
    {
        if ($this->endDate) {
            $this->endDate->modify('midnight');
        }
        return $this->endDate;
    }

    public function getDays($sort)
    {
        $days = $this->days;
        $days = DocumentUtil::sortDocuments($days, 'getDate', 'desc');
        return $days;
    }

    public function setDays($days)
    {
        $this->days = $days;
    }
}
