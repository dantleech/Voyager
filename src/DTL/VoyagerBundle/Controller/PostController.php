<?php

namespace DTL\VoyagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DTL\VoyagerBundle\Document\Post;
use DTL\VoyagerBundle\Form\PostType;

class PostController extends Controller
{
    public function newAction()
    {
        $post = new Post;
        return $this->processModify($post);
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

        return $this->render('DTLTrainerBundle:Post:'.$template.'.html.twig', array(
            'post' => $post,
            'form' => $form->createView(),
        ));
    }
}
