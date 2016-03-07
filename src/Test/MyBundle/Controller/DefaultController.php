<?php

namespace Test\MyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('TestMyBundle:Default:index.html.twig', array('name' => $name));
    }
}
