<?php

namespace WebdevVysocina\MeetingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('WebdevVysocinaMeetingBundle:Default:index.html.twig');
    }
}
