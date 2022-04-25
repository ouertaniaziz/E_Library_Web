<?php

namespace App\Controller;

use App\Entity\Users;
use App\Entity\Role;
use App\Form\ProfilType;
use App\Repository\UsersRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\LoginType;


use Symfony\Component\HttpFoundation\Session\Session;

class LoginController extends AbstractController
{
    /**
     * @Route("/login", name="app_login_login",methods={"GET","POST"})
     */
    public function index(Request $request, EntityManagerInterface $manager,UsersRepository $rep)
    {   $user = new Users();
        $form = $this->createForm(LoginType::class,$user);
        $form->handleRequest($request);

        if ($form->isSubmitted() ) {
            $email = $form->get('emailUser')->getData();
            $mdp = $form->get('mdpUser')->getData();
           // $bdd = $manager->getRepository(Users::class);
            if ( $user = $this->getDoctrine()->getRepository(Users::class)->findOneBy(['emailUser' => $email,'mdpUser' => md5($mdp)])) {
                if($user->getBloquer()==1)
                { echo "<div class='p-3 mb-2 bg-danger'>ce compte est bloquer</div>";}
                if($user->getRole()->getRole()=='client'){
                    $ok=$rep->findByEmail($user->getEmailUser(),$user->getMdpUser());
                    //    $session = new Session();
                    //  $session->set('emailUser', $email);
                    $session = $request->getSession();
                    $session->set('user',$ok);
                    $session->set('idUser',$ok[0]->getIdUser());
                    return $this->redirectToRoute('app_home');
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

    /**
     * @Route("/{idUser}/profil", name="app_profil",methods={"GET","POST"})
     */
    public function profil(Request $request, Users $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProfilType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $entityManager->flush();
            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('users/profil.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/home", name="app_home",methods={"GET","POST"})
     */
    public function home (SessionInterface $session):Response
    {
        $user=$session->get('idUser');

        if ($user==null){
            return $this->redirectToRoute('app_login_login');
        }else{
            return $this->render('home_page/HomePageClient.html.twig',
                ['controller_name'=>'HomeController',
                    'user'=>$user
                ]);
        }
    }


}

