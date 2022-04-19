<?php

namespace App\Controller;
use App\Entity\Users;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="app_home",methods={"GET","POST"})
     */
    public function index (SessionInterface $session):Response
    {
    $user=$session->get('emailUser');
    if ($user==null){
        return $this->redirectToRoute('app_login_login');
    }else{
        return $this->render('login/home.html.twig',
        ['controller_name'=>'HomeController',
            'user'=>$user
        ]);
    }
    }}