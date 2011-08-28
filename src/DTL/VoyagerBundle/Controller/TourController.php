<?php

namespace DTL\VoyagerBundle\Controller;

use DTL\TrainerBundle\Controller\Controller;
use DTL\VoyagerBundle\Document\Tour;
use DTL\VoyagerBundle\Form\TourType;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineODMMongoDBAdapter;

class TourController extends Controller
{
    protected function getTour()
    {
        return $this->getDocumentFromRequest('DTL\VoyagerBundle\Document\Tour', 'tour_id');
    }

    public function newAction()
    {
        $tour = new Tour;
        return $this->processModify($tour);
    }

    public function editAction()
    {
        $tour = $this->getTour();
        return $this->processModify($tour);
    }

    public function viewAction()
    {
        $tour = $this->getTour();
        return $this->render('DTLVoyagerBundle:Tour:view.html.twig', array(
            'tour' => $tour,
        ));
    }

    public function deleteAction()
    {
        $tour = $this->getTour();
        $this->getDm()->remove($tour);
        $this->getDm()->flush();
        return $this->redirect($this->generateUrl('tour_index'));
    }

    public function indexAction()
    {
        $repo = $this->getRepo('DTLVoyagerBundle:Tour');
        $query = $repo->createQueryBuilder();
        $query->sort('date', 'asc');
        $adapter = new DoctrineODMMongoDBAdapter($query);
        $pager = new Pagerfanta($adapter);
        $pager->setCurrentPage($this->get('request')->get('page', 1));

        return $this->render('DTLVoyagerBundle:Tour:index.html.twig', array(
            'pager' => $pager,
        ));
    }

    protected function processModify($tour)
    {
        $form = $this->createForm(new TourType(), $tour);
        $message = $tour->getId() ? 'Tour Updated' : 'Tour Created';
        $template = $tour->getId() ? 'edit' : 'new';

        if ($this->processForm($form)) {
            $this->notifySuccess($message);
            return $this->redirect($this->generateUrl('tour_view', array('tour_id' => $tour->getId())));
        }

        return $this->render('DTLVoyagerBundle:Tour:'.$template.'.html.twig', array(
            'tour' => $tour,
            'form' => $form->createView(),
        ));
    }
}
