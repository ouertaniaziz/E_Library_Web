<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomePageController extends AbstractController
{
    /**
     * @Route("/", name="app_home_page")
     */
    public function index(): Response
    {
        return $this->render('home_page/HomePageUser.html.twig', [
            'controller_name' => 'HomePageController',
        ]);
    }
    /**
     * @Route("/LoginClient", name="app_home_page_client")
     */
    public function indexclient(): Response
    {
        return $this->render('home_page/HomePageClient.html.twig', [
            'controller_name' => 'HomePageController',
        ]);
    }
}
