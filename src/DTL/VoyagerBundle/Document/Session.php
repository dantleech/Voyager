<?php

namespace DTL\VoyagerBundle\Document;

use DTL\TrainerBundle\Document\Session as BaseSession;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

class Session extends BaseSession
{
    /**
     * @MongoDB\ReferenceOne(targetDocument="DTL\VoyagerBundle\Document\Tour")
     */
    protected $tour;
}
