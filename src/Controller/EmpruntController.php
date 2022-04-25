<?php

namespace App\Controller;

use App\Entity\Abonnement;
use App\Entity\Emprunt;
use App\Entity\Ouverage;
use App\Entity\Users;
use App\Form\EmpruntType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/emprunt")
 */
class EmpruntController extends AbstractController
{
    /**
     * @Route("/", name="app_emprunt_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager, Request $request, PaginatorInterface $paginator): Response
    {
        $donnees = $entityManager
            ->getRepository(Emprunt::class)
            ->findAll();
        $emprunts = $paginator->paginate(
            $donnees, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            3// Nombre de résultats par page
        );

        return $this->render('emprunt/index.html.twig', [
            'emprunts' => $emprunts,
        ]);
    }

    /**
     * @Route("/new/{id_client}/{id_livre}/{nbr_semaine}", name="app_emprunt_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager, $nbr_semaine, $id_client, $id_livre): Response
    {
        /* inutile de declarer les objet
        $abonnement = new Abonnement();
        $ouverage = new Ouverage();
        */
        $ouverage = $this->getDoctrine()->getRepository(Ouverage::class)->findOneBy(['id' => $id_livre]);
        $abonnement = $this->getDoctrine()->getRepository(Abonnement::class)->findOneBy(
            ['idUser' => $id_client]);


        dd($this->getUser());
        $emprunt = new Emprunt();
        $emprunt->setIdOuvrage($ouverage);
        $emprunt->setDateEmprunt(new \DateTime('now'));
        # $emprunt->setDateRetourOuvrage(strtotime("+1 week")); attentionn il faut terminer cette configuration de date
        $emprunt->setDateRetourOuvrage(new \DateTime('now'));
        $emprunt->setIdAbonnement($abonnement);
        $abonnement->setSolde($abonnement->getSolde() - ($ouverage->getPrixEmprunt() * $nbr_semaine));
        $entityManager->persist($emprunt);
        $entityManager->flush();
        return $this->redirectToRoute('app_emprunt_index', [], Response::HTTP_SEE_OTHER);


    }

    /**
     * @Route("/{idEmprunt}", name="app_emprunt_show", methods={"GET"})
     */
    public function show(Emprunt $emprunt): Response
    {
        return $this->render('emprunt/show.html.twig', [
            'emprunt' => $emprunt,
        ]);
    }

    /**
     * @Route("/{idEmprunt}/edit", name="app_emprunt_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Emprunt $emprunt, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EmpruntType::class, $emprunt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_emprunt_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('emprunt/edit.html.twig', [
            'emprunt' => $emprunt,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idEmprunt}", name="app_emprunt_delete", methods={"POST"})
     */
    public function delete(Request $request, Emprunt $emprunt, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $emprunt->getIdEmprunt(), $request->request->get('_token'))) {
            $entityManager->remove($emprunt);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_emprunt_index', [], Response::HTTP_SEE_OTHER);
    }
}
