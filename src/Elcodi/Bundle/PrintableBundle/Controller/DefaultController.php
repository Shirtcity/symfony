<?php

namespace Elcodi\Bundle\PrintableBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('ElcodiPrintableBundle:Default:index.html.twig', array('name' => $name));
    }
}
