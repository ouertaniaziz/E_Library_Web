<?php

namespace App\Controller;

use App\Entity\Users;
use App\Entity\Role;
use App\Repository\UsersRepository;
use App\Form\ClientType;
use App\Form\ResetMdpType;
use App\Repository\RoleRepository;
use App\Form\MdpType;
use App\Form\UsersType;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Self_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

/**
 * @Route("/users")
 */
class UsersController extends AbstractController
{
    /**
     * @Route("/", name="app_users_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager,UsersRepository $u): Response
    {

        // $users = $entityManager
        //    ->getRepository(Users::class)
        //   ->findAll();
        $userById=$u->listByOrder();

        return $this->render('users/index.html.twig', [
            'users' => $userById,
        ]);
    }

    /**
     * @Route("/sortper", name="app_users_sortper", methods={"GET", "POST"})
     */
    public function sortPersonnel(UsersRepository $u): Response
    {
        $userByRole=$u->findPersonnel();
        return $this->render('users/index.html.twig', [
            'users' => $userByRole,
        ]);
    }
    /**
     * @Route("/sortcli", name="app_users_sortcli", methods={"GET", "POST"})
     */
    public function sortclient (UsersRepository $u): Response
    {
        $userByRole=$u->findClient();
        return $this->render('users/index.html.twig', [
            'users' => $userByRole,
        ]);
    }

    /**
     * @Route("/new", name="app_users_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager, MailerInterface $mailer): Response
    {
        $user = new Users();
        $form = $this->createForm(UsersType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $Random_str = uniqid();
            $user->setMdpUser($Random_str);
            $entityManager->persist($user);
            $entityManager->flush();
            $user->sendPassword($mailer);
            $user->setMdpUser(md5($Random_str));
            $entityManager->persist($user);
            $entityManager->flush();



            return $this->redirectToRoute('app_users_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('users/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/newClient", name="app_login_newClient", methods={"GET", "POST"})
     */
    public function newClient(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new Users();

        $role = $this->getDoctrine()->getRepository(Role::class)->findOneBy(['id' => 1,'role' => 'client']) ;
        $user->setRole($role);
        $form = $this->createForm(ClientType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $mdp = $form->get('mdpUser')->getData();
            $user->setMdpUser(md5($mdp));

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_login_login', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('login/newClient.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/newMdp", name="app_login_newMdp",methods={"GET","POST"})
     */
    public function Mdp (Request $request, EntityManagerInterface $manager, MailerInterface $mailer):Response
    {
        $user = new Users();
        $form = $this->createForm(MdpType::class,$user);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $email = $form->get('emailUser')->getData();
            $user = $this->getDoctrine()->getRepository(Users::class)->findOneBy(['emailUser' => $email]);
            $Random_str = uniqid();
            $user->setCode($Random_str) ;
            $user->newPassword($mailer);
            $manager = $this->getDoctrine()->getManager();
            $manager->flush();
            return $this->redirectToRoute('app_login_ResetMdp', [], Response::HTTP_SEE_OTHER);

        } return $this->render('login/newMdp.html.twig', [
        'user' => $user,
        'form' => $form->createView(),
    ]);

    }
    /**
     * @Route("/ResetMdp", name="app_login_ResetMdp",methods={"GET","POST"})
     */
    public function ResetMdp (Request $request, EntityManagerInterface $manager, MailerInterface $mailer):Response
    {
        $user = new Users();
        $form = $this->createForm(ResetMdpType::class,$user);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $code=$form->get('code')->getData();
            // $mdp = $form->get('mdpUser')->getData();
            $user = $this->getDoctrine()->getRepository(Users::class)->findOneBy(['code' => $code]);
            $user->setMdpUser(md5($form->get('mdpUser')->getData()));
            $manager = $this->getDoctrine()->getManager();
            $manager->flush();
            return $this->redirectToRoute('app_login_login', [], Response::HTTP_SEE_OTHER);

        } return $this->render('login/ResetMdp.html.twig', [
        'user' => $user,
        'form' => $form->createView(),
    ]);
    }



    /**
     * @Route("/{idUser}", name="app_users_show", methods={"GET"})
     */
    public function show(Users $user ): Response
    {
        return $this->render('users/show.html.twig', [
            'user' => $user,

        ]);
    }
    /**
     * @Route("/{idUser}/bloquer", name="app_users_bloquer", methods={"GET", "POST"})
     */
    public function bloquer(Request $request, Users $user, EntityManagerInterface $entityManager): Response
    {
        $user->setBloquer(1);
        $entityManager->flush();
        return $this->redirectToRoute('app_users_index', [], Response::HTTP_SEE_OTHER);
    }
    /**
     * @Route("/{idUser}/debloquer", name="app_users_debloquer", methods={"GET", "POST"})
     */
    public function debloquer(Request $request, Users $user, EntityManagerInterface $entityManager): Response
    {
        $user->setBloquer(0);
        $entityManager->flush();
        return $this->redirectToRoute('app_users_index', [], Response::HTTP_SEE_OTHER);
    }



    /**
     * @Route("/{idUser}/edit", name="app_users_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Users $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UsersType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_users_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('users/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{idUser}", name="app_users_delete", methods={"POST"})
     */
    public function delete(Request $request, Users $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getIdUser(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_users_index', [], Response::HTTP_SEE_OTHER);
    }

}
