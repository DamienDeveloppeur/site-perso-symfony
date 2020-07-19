<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class NavigationController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        dump("ca marche");
        return $this->render('navigation/index.html.twig', [
            'controller_name' => 'NavigationController',
            'title' => 'HEY'
        ]);
    }

    /**
     * @Route("/onepage", name="onePage")
     */
    public function indexOnepage()
    {
        dump("ca marche");

        return $this->render('navigation/index.html.twig', [
            'controller_name' => 'NavigationController',
            'title' => 'HEY'
        ]);
    }
}


