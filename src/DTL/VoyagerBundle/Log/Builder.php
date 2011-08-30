<?php

namespace DTL\VoyagerBundle\Log;
use Doctrine\ODM\MongoDB\DocumentManager;
use DTL\TrainerBundle\Util\DocumentUtil;
use DTL\VoyagerBundle\Document\Tour;
use DTL\VoyagerBundle\Document\Stage;

class Builder
{
    protected $dm;

    public function __construct(DocumentManager $dm)
    {
        $this->dm = $dm;
    }

    public function getStages(Tour $tour)
    {
        $repo = $this->dm->getRepository('DTLVoyagerBundle:Stage');
        $qb = $repo->createQueryBuilder();
        $qb->field('tour.$id')->equals(new \MongoID($tour->getId()));
        $qb->sort('startDate');
        $stages = $qb->getQuery()->execute();
        $lastStage = null;

        foreach ($stages as $stage) {
            $this->buildStage($stage);
            if ($lastStage) {
                $lastStage->setEndDate($stage->getStartDate());
            }

            $lastStage = $stage;
        }

        return $stages;
    }

    public function buildStage($stage)
    {
        $events = array_merge(
            $this->getSessions($stage->getStartDate(), $stage->getEndDate()),
            $this->getPosts($stage)
        );

        $days = array();

        foreach ($events as $event) {
            if (!isset($days[$event->getDate()->format('Ymd')])) {
                $day = new Day;
                $day->setDate($event->getDate());
                $days[$event->getDate()->format('Ymd')] = $day;
            }
            $days[$event->getDate()->format('Ymd')]->addEvent($event);
        }

        $days = DocumentUtil::sortDocuments($days, 'getDate');

        $stage->setDays($days);
    }

    public function getStats($tour)
    {
        $stats = array();
        $stages = $this->getStages($tour);
        $lastDay = null;
        $firstDay = null;
        $meters = 0;
        $seconds = 0;

        foreach ($stages as $stage) {
            foreach ($stage->getDays() as $day) {
                if (!$firstDay) {
                    $firstDay = $day->getDate();
                }

                if (!$lastDay) {
                    $lastDay = $day->getDate();
                }

                if ($day->getDate()->format('U') < $firstDay->format('U')) {
                    $firstDay = $day->getDate();
                }

                if ($day->getDate()->format('U') > $lastDay->format('U')) {
                    $lastDay = $day->getDate();
                }

                foreach ($day->getEvents() as $event) {
                    if ($event->getType() == 'Session') {
                        $meters += $event->getDistance();
                        $seconds += $event->getTime();
                    }
                }
            }
        }

        $stats['lastDay'] = $lastDay;
        $stats['firstDay'] = $firstDay;
        $stats['days'] = floor(($lastDay->format('U') - $firstDay->format('U')) / 86400);
        $stats['meters'] = $meters;
        $stats['seconds'] = $seconds;

        return $stats;
    }

    public function getSessions($startDate, $endDate = null)
    {
        $qb = $this->dm->getRepository('DTLVoyagerBundle:Session')->createQueryBuilder();
        $qb->field('date')->gte($startDate);
        if ($endDate) {
            $qb->field('date')->lte($endDate);
        }
        $sessions = $qb->getQuery()->execute()->toArray();
        return $sessions;
    }

    public function getPosts($stage)
    {
        $qb = $this->dm->getRepository('DTLVoyagerBundle:Post')->createQueryBuilder();
        $qb->field('date')->gte($stage->getStartDate());
        if ($stage->getEndDate()) {
            $qb->field('date')->lte($stage->getEndDate());
        }

        $posts = $qb->getQuery()->execute()->toArray();
        return $posts;
    }
}
