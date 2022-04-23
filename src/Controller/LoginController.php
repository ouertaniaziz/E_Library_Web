<?php

namespace App\Controller;

use App\Entity\Users;
use App\Entity\Role;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\LoginType;


use Symfony\Component\HttpFoundation\Session\Session;

class LoginController extends AbstractController
{
    /**
     * @Route("/login", name="app_login_login",methods={"GET","POST"})
     */
    public function index(Request $request, EntityManagerInterface $manager)
    {   $user = new Users();
        $form = $this->createForm(LoginType::class,$user);
        $form->handleRequest($request);

        if ($form->isSubmitted() ) {
            $email = $form->get('emailUser')->getData();
            $mdp = $form->get('mdpUser')->getData();
            $bdd = $manager->getRepository(Users::class);


            if ( $user = $this->getDoctrine()->getRepository(Users::class)->findOneBy(['emailUser' => $email,'mdpUser' => md5($mdp)])) {
                if($user->getBloquer()==1)
                { echo "<div class='p-3 mb-2 bg-danger'>ce compte est bloquer</div>";}
                if($user->getRole()->getRole()=='client'){
                   // $userid = $this->getDoctrine()->getRepository(Users::class)->find('idUser');
                    $session = new Session();
                    $session->set('emailUser', $email);
                    return $this->redirectToRoute('app_home_page_client');
                }
                else {return $this->redirectToRoute('app_users_index');}
            } else{
                echo "<div class='p-3 mb-2 bg-danger'>ce compte n'existe pas</div>";
            }
        }

        return $this->render('login/login.html.twig',
            [
                'controller_name'=>'LoginController',
                'form' => $form->createView(),
            ]);
    }


}

