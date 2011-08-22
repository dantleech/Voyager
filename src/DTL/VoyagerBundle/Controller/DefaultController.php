<?php

namespace DTL\VoyagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction()
    {
        return $this->render('DTLVoyagerBundle:Default:index.html.twig');
    }
}
