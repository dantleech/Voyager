<?php

namespace DTL\VoyagerBundle\Controller;

use DTL\TrainerBundle\Controller\Controller;
use DTL\VoyagerBundle\Document\Post;
use DTL\VoyagerBundle\Form\PostType;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineODMMongoDBAdapter;

class PostController extends Controller
{
    protected function getPost()
    {
        return $this->getDocumentFromRequest('DTL\VoyagerBundle\Document\Post', 'post_id');
    }

    public function newAction()
    {
        $post = new Post;
        $post->setDate(new \DateTime());
        return $this->processModify($post);
    }

    public function editAction()
    {
        $post = $this->getPost();
        return $this->processModify($post);
    }

    public function viewAction()
    {
        $post = $this->getPost();
        return $this->render('DTLVoyagerBundle:Post:view.html.twig', array(
            'post' => $post,
        ));
    }

    public function deleteAction()
    {
        $post = $this->getPost();
        $this->getDm()->remove($post);
        $this->getDm()->flush();
        return $this->redirect($this->generateUrl('post_index'));
    }

    public function indexAction()
    {
        $repo = $this->getRepo('DTLVoyagerBundle:Post');
        $query = $repo->createQueryBuilder();
        $query->sort('date', 'asc');
        $adapter = new DoctrineODMMongoDBAdapter($query);
        $pager = new Pagerfanta($adapter);
        $pager->setCurrentPage($this->get('request')->get('page', 1));

        return $this->render('DTLVoyagerBundle:Post:index.html.twig', array(
            'pager' => $pager,
        ));
    }

    protected function processModify($post)
    {
        $form = $this->createForm(new PostType(), $post);
        $message = $post->getId() ? 'Post Updated' : 'Post Created';
        $template = $post->getId() ? 'edit' : 'new';

        if ($this->processForm($form)) {
            $this->notifySuccess($message);
            return $this->redirect($this->generateUrl('post_view', array('post_id' => $post->getId())));
        }

        return $this->render('DTLVoyagerBundle:Post:'.$template.'.html.twig', array(
            'post' => $post,
            'form' => $form->createView(),
        ));
    }
}
