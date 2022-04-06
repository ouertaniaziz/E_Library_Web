<?php

namespace App\Controller;

use App\Entity\Ouverage;
use App\Form\OuverageType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ouverage")
 */
class OuverageController extends AbstractController
{
    /**
     * @Route("/", name="app_ouverage_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $ouverages = $entityManager
            ->getRepository(Ouverage::class)
            ->findAll();

        return $this->render('ouverage/index.html.twig', [
            'ouverages' => $ouverages,
        ]);
    }

    /**
     * @Route("/new", name="app_ouverage_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $ouverage = new Ouverage();
        $form = $this->createForm(OuverageType::class, $ouverage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($ouverage);
            $entityManager->flush();

            return $this->redirectToRoute('app_ouverage_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ouverage/new.html.twig', [
            'ouverage' => $ouverage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_ouverage_show", methods={"GET"})
     */
    public function show(Ouverage $ouverage): Response
    {
        return $this->render('ouverage/show.html.twig', [
            'ouverage' => $ouverage,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_ouverage_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Ouverage $ouverage, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(OuverageType::class, $ouverage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_ouverage_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ouverage/edit.html.twig', [
            'ouverage' => $ouverage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_ouverage_delete", methods={"POST"})
     */
    public function delete(Request $request, Ouverage $ouverage, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ouverage->getId(), $request->request->get('_token'))) {
            $entityManager->remove($ouverage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_ouverage_index', [], Response::HTTP_SEE_OTHER);
    }
}
