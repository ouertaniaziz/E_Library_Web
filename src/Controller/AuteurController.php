<?php

namespace App\Controller;

use App\Entity\Auteur;
use App\Form\AuteurType;
use App\Service\UploaderHelper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/auteur")
 */
class AuteurController extends AbstractController
{
    /**
     * @Route("/", name="app_auteur_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $auteurs = $entityManager
            ->getRepository(Auteur::class)
            ->findAll();

        return $this->render('auteur/index.html.twig', [
            'auteurs' => $auteurs,
        ]);
    }

    /**
     * @Route("/new", name="app_auteur_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager, UploaderHelper $uploaderHelper): Response
    {
        $auteur = new Auteur();
        $form = $this->createForm(AuteurType::class, $auteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $form['photoFile']->getData();
            if ($uploadedFile) {
                $newFileName = $uploaderHelper->uploadFile($uploadedFile);
                $auteur->setPhotoAuteur($newFileName);
            }
            $entityManager->persist($auteur);
            $entityManager->flush();
            $this->addFlash('success', 'Auteur ajouté avec succès');
            return $this->redirectToRoute('app_auteur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('auteur/new.html.twig', [
            'auteur' => $auteur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idAuteur}", name="app_auteur_show", methods={"GET"})
     */
    public function show(Auteur $auteur): Response
    {
        return $this->render('auteur/show.html.twig', [
            'auteur' => $auteur,
        ]);
    }

    /**
     * @Route("/{idAuteur}/edit", name="app_auteur_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Auteur $auteur, EntityManagerInterface $entityManager, UploaderHelper $uploaderHelper): Response
    {
        $form = $this->createForm(AuteurType::class, $auteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $form['photoFile']->getData();
            if ($uploadedFile) {
                $newFileName = $uploaderHelper->uploadFile($uploadedFile);
                $auteur->setPhotoAuteur($newFileName);
            }
            $entityManager->persist($auteur);
            $entityManager->flush();

            $this->addFlash('success', 'Auteur mis à jour');

            return $this->redirectToRoute('app_auteur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('auteur/edit.html.twig', [
            'auteur' => $auteur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idAuteur}", name="app_auteur_delete", methods={"POST"})
     */
    public function delete(Request $request, Auteur $auteur, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $auteur->getIdAuteur(), $request->request->get('_token'))) {
            $entityManager->remove($auteur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_auteur_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/admin/upload/test", name="upload_test")
     */
    public function temporaryUploadAction(Request $request)
    {
        /** @var UploadedFile $uploadedFile */
        $uploadedFile = $request->files->get('image');


    }
}
