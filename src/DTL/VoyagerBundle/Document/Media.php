<?php

namespace DTL\VoyagerBundle\Document;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use DTL\VoyagerBundle\Log\EventInterface;

/**
 * @MongoDB\Document()
 */
class Media implements EventInterface
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\Date
     */
    protected $date;

    /**
     * @MongoDB\String
     */
    protected $filename;

    /**
     * @MongoDB\Hash
     */
    protected $meta = array();

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
     * Set date
     *
     * @param date $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * Get date
     *
     * @return date $date
     */
    public function getDate()
    {
        return $this->date;
    }

    public function getType()
    {
        return 'Media';
    }

    /**
     * Set filename
     *
     * @param string $filename
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
    }

    /**
     * Get filename
     *
     * @return string $filename
     */
    public function getFilename()
    {
        return $this->filename;
    }

    public function setMeta($meta)
    {
        $this->meta = $meta;
    }

    public function getMeta()
    {
        return $this->meta;
    }
}
