<?php

namespace DTL\VoyagerBundle\Log;

class Day
{
    protected $date;
    protected $events = array();

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
}
