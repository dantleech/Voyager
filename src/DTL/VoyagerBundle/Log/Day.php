<?php

namespace DTL\VoyagerBundle\Log;

class Day
{
    protected $date;
    protected $events = array();
    protected $medias = array();

    public function getDate()
    {
        return $this->date;
    }

    public function setDate(\DateTime $date)
    {
        $this->date = $date;
    }

    public function addEvent(EventInterface $event)
    {
        $this->events[] = $event;
    }

    public function getEvents()
    {
        return $this->events;
    }

    public function setMedias($medias)
    {
        $this->medias = $medias;
    }

    public function getMedias()
    {
        return $this->medias;
    }

    public function addMedia($media)
    {
        $this->medias[] = $media;
    }
}
