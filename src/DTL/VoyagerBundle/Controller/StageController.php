<?php

namespace DTL\VoyagerBundle\Controller;

use DTL\TrainerBundle\Controller\Controller;
use DTL\VoyagerBundle\Document\Stage;
use DTL\VoyagerBundle\Form\StageType;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineODMMongoDBAdapter;

class StageController extends Controller
{
    protected function getStage()
    {
        return $this->getDocumentFromRequest('DTL\VoyagerBundle\Document\Stage', 'stage_id');
    }

    public function newAction()
    {
        $stage = new Stage;
        $stage->setStartDate(new \DateTime());
        return $this->processModify($stage);
    }

    public function editAction()
    {
        $stage = $this->getStage();
        return $this->processModify($stage);
    }

    public function viewAction()
    {
        $stage = $this->getStage();
        return $this->render('DTLVoyagerBundle:Stage:view.html.twig', array(
            'stage' => $stage,
        ));
    }

    public function deleteAction()
    {
        $stage = $this->getStage();
        $this->getDm()->remove($stage);
        $this->getDm()->flush();
        return $this->redirect($this->generateUrl('stage_index'));
    }

    public function indexAction()
    {
        $repo = $this->getRepo('DTLVoyagerBundle:Stage');
        $query = $repo->createQueryBuilder();
        $query->sort('date', 'asc');
        $adapter = new DoctrineODMMongoDBAdapter($query);
        $pager = new Pagerfanta($adapter);
        $pager->setCurrentPage($this->get('request')->get('page', 1));

        return $this->render('DTLVoyagerBundle:Stage:index.html.twig', array(
            'pager' => $pager,
        ));
    }

    protected function processModify($stage)
    {
        $form = $this->createForm(new StageType(), $stage);
        $message = $stage->getId() ? 'Stage Updated' : 'Stage Created';
        $template = $stage->getId() ? 'edit' : 'new';

        if ($this->processForm($form)) {
            $this->notifySuccess($message);
            return $this->redirect($this->generateUrl('stage_view', array('stage_id' => $stage->getId())));
        }

        return $this->render('DTLVoyagerBundle:Stage:'.$template.'.html.twig', array(
            'stage' => $stage,
            'form' => $form->createView(),
        ));
    }
}
