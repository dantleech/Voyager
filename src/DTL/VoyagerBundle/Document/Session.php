<?php

namespace DTL\VoyagerBundle\Document;

use DTL\TrainerBundle\Document\Session as BaseSession;
use DTL\VoyagerBundle\Log\EventInterface;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document(repositoryClass="DTL\TrainerBundle\Repository\SessionRepository")
 */
class Session extends BaseSession implements EventInterface
{
    public function getType()
    {
        return 'Session';
    }
}
