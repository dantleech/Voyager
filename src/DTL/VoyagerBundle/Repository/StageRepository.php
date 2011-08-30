<?php

namespace DTL\VoyagerBundle\Repository;
use Doctrine\ODM\MongoDB\DocumentRepository;
use DTL\VoyagerBundle\Util\DocumentUtil;

class StageRepository extends DocumentRepository
{
    public function getMostRecentStage()
    {
        $qb = $this->createQueryBuilder();
        $qb->sort('date', 'desc');
        $qb->limit(1);
        $mostRecent = $qb->getQuery()->getSingleResult();

        return $mostRecent;
    }
}

