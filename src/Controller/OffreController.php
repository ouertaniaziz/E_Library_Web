<?php

namespace App\Controller;

use App\Entity\Offre;
use App\Form\OffreType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @Route("/offre")
 */
class OffreController extends AbstractController
{
    /**
     * @Route("/", name="app_offre_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager, Request $request, PaginatorInterface $paginator): Response
    {
        $donnees = $entityManager
            ->getRepository(Offre::class)
            ->findAll();
        $offres=$paginator->paginate(
            $donnees, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            3// Nombre de résultats par page
        );
        return $this->render('offre/index.html.twig', [
            'offres' => $offres,
        ]);
    }
    /**
     * @Route("/AccueilUser", name="app_offre_AccueilUser")
     */
    public function index_User(EntityManagerInterface $entityManager, Request $request, PaginatorInterface $paginator): Response
    {
        $donnees = $entityManager
            ->getRepository(Offre::class)
            ->findAll();
        $offres=$paginator->paginate(
            $donnees, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
           3// Nombre de résultats par page
        );
        return $this->render('offre/AccueilUser.html.twig',[
        'offres' => $offres,
        ]

        );
    }
    /**
     * @Route("/AccueilClient", name="app_offre_AccueilClient")
     */
    public function index_client(EntityManagerInterface $entityManager, Request $request, PaginatorInterface $paginator): Response
    {
        $donnees = $entityManager
            ->getRepository(Offre::class)
            ->findAll();
        $offres=$paginator->paginate(
            $donnees, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            3// Nombre de résultats par page
        );
        return $this->render('offre/AccueilClient.html.twig',[
                'offres' => $offres,
            ]

        );
    }
    /**
     * @Route("/new", name="app_offre_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $offre = new Offre();
        $form = $this->createForm(OffreType::class, $offre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($offre);
            $entityManager->flush();

            return $this->redirectToRoute('app_offre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('offre/new.html.twig', [
            'offre' => $offre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idOffre}/admin", name="app_offre_show", methods={"GET"})
     */
    public function show(Offre $offre): Response
    {
        return $this->render('offre/show.html.twig', [
            'offre' => $offre,
        ]);
    }
    /**
     * @Route("/{idOffre}", name="app_offre_show_User", methods={"GET"})
     */
    public function showUser(Offre $offre): Response
    {
        return $this->render('offre/ShowUser.html.twig', [
            'offre' => $offre,
        ]);
    }
    /**
     * @Route("/{idOffre}/client", name="app_offre_show_Client", methods={"GET"})
     */
    public function showClient(Offre $offre): Response
    {
        return $this->render('offre/ShowCLient.html.twig', [
            'offre' => $offre,
        ]);
    }
    /**
     * @Route("/{idOffre}/edit", name="app_offre_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Offre $offre, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(OffreType::class, $offre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_offre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('offre/edit.html.twig', [
            'offre' => $offre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idOffre}", name="app_offre_delete", methods={"POST"})
     */
    public function delete(Request $request, Offre $offre, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$offre->getIdOffre(), $request->request->get('_token'))) {
            $entityManager->remove($offre);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_offre_index', [], Response::HTTP_SEE_OTHER);
    }
}
