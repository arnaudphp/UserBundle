<?php

namespace Leoo\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('LeooUserBundle:Default:index.html.twig');
    }
}
