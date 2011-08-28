<?php

namespace DTL\VoyagerBundle\Log;
use DTL\TrainerBundle\Util\DocumentUtil;

class Builder
{
    protected $dm;

    public function __contruct(DocumentManager $dm)
    {
        $this->dm = $dm;
    }

    public function getStages(Tour $tour)
    {
        $repo = $this->dm->getRepository('DTLVoyagerBundle:Stage');
        $qb = $repo->createQueryBuilder();
        $qb->field('tour.$id')->eq($tour->getId());
        $qb->sort('startDate');
        $stages = $qb->execute();
        $lastStage = null;

        foreach ($stages as $stage) {
            if ($lastStage) {
                $lastStage->setEndDate($stage->getStartDate());
            }

            $lastStage = $stage;
        }


        return $stages;
    }

    public function initStage(Stage $stage)
    {
        foreach ($this->getStages($stage->getTour()) as $compStage) {
            if ($compStage->getId() == $stage->getId()) {
                $stage->setEndDate($compStage->getEndDate());
            }
        }

        return $stage;
    }

    public function getLogBook($stage)
    {
        $this->initStage($stage);

        $events = array_merge(
            $this->getSessions($stage),
            $this->getPosts($stage),
        );

        $days = array();

        foreach ($events as $event) {
            if (!isset($days[$event->getDate()->format('Ymd'))) {
                $day = new Day;
                $day->setDate($event->getDate();
                $days[$event->getDate()->format('Ymd')];
            }
            $day->addEvent($event);
        }

        $days = DocumentUtil::sortDocuments($days, 'getDate');

        return $days;
    }

    public function getSessions()
    {
        $qb = $this->dm->getRepository('DTLVoyagerBundle:Session')->createQueryBuilder();
        $qb->field('date')->gte($stage->getStartDate());
        $qb->field('date')->lte($stage->getEndDate());
        $sessions = $qb->execute();
        return $sessions;
    }

    public function getPosts()
    {
        $qb = $this->dm->getRepository('DTLTrainerBundle:Post')->createQueryBuilder();
        $qb->field('date')->gte($stage->getStartDate());
        $qb->field('date')->lte($stage->getEndDate());
        $posts = $qb->execute();
        return $posts;
    }
}
