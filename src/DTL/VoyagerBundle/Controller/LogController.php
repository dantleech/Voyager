<?php

namespace DTL\VoyagerBundle\Controller;

use DTL\TrainerBundle\Controller\Controller;

class LogController extends Controller
{
    public function getTour()
    {
        $mostRecentStage = $this->getRepo('DTLVoyagerBundle:Stage')->getMostRecentStage();
        return $mostRecentStage->getTour();
    }

    public function indexAction()
    {
        $tour = $this->getTour();
        $stages = $this->get('dtl_voyager.log_builder')->getStages($tour);

        return $this->render('DTLVoyagerBundle:Log:index.html.twig', array(
            'stages' => $stages,
        ));
    }

    public function headerAction()
    {
        $tour = $this->getTour();
        $stats = $this->get('dtl_voyager.log_builder')->getStats($tour);

        return $this->render('DTLVoyagerBundle::_header.html.twig', array(
            'tour' => $tour,
            'stats' => $stats,
        ));
    }

    public function sessionListAction()
    {
        $tour = $this->getTour();
        $stats = $this->get('dtl_voyager.log_builder')->getStats($tour);
        $sessions = $this->get('dtl_voyager.log_builder')->getSessions($stats['firstDay'], $stats['lastDay']);

        return $this->render('DTLVoyagerBundle::_sessionList.html.twig', array(
            'tour' => $tour,
            'sessions' => $sessions,
        ));
    }
}
