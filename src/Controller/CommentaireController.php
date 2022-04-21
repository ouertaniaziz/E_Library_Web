<?php

namespace App\Controller;
use App\Entity\Evenement;
use App\Entity\Commentaire;
use App\Form\CommentaireType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/commentaire")
 */
class CommentaireController extends AbstractController
{
    /**
     * @Route("/", name="app_commentaire_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $commentaires = $entityManager
            ->getRepository(Commentaire::class)
            ->findAll();

        return $this->render('commentaire/index.html.twig', [
            'commentaires' => $commentaires,

        ]);
    }

    /**
     * @Route("{id}", name="app_commentaire_new", methods={"GET", "POST"})
     */
    public function new($id, Request $request): Response
    {
        $commentaire = new commentaire();
        $event=$this->getDoctrine()->getRepository(Evenement::class)->find($id);
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);
        $commentaire->addIdEvent($event);
        if ($form->isSubmitted() && $form->isValid() ) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($commentaire);
            $em->flush();
            return $this->redirectToRoute('app_commentaire_show', ['id' => $event->getId()]);
        }return $this->render('participant/new.html.twig', [
        'commentaire' => $commentaire,
        'form' => $form->createView(),
    ]);}

    /**
     * @Route("/{id}", name="app_commentaire_show")
     */
    public function show( $id, EntityManagerInterface $manager ): Response
    {

        $commantaire= $manager->createQuery('select c.commentaire from 
  App\Entity\Commentaire c 
  where c.event=:param
')
            ->setParameter('param',$id)
            ->getResult();

        return $this->render('commentaire/show.html.twig', [
            'commentaire' => $commantaire,

        ]);
    }

    /**
     * @Route("/{idCommentaire}/edit", name="app_commentaire_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Commentaire $commentaire, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_commentaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('commentaire/edit.html.twig', [
            'commentaire' => $commentaire,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idCommentaire}", name="app_commentaire_delete", methods={"POST"})
     */
    public function delete(Request $request, Commentaire $commentaire, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commentaire->getIdCommentaire(), $request->request->get('_token'))) {
            $entityManager->remove($commentaire);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_evenement_index', [], Response::HTTP_SEE_OTHER);
    }
}
