<?php

namespace App\Controller;

use App\Entity\Ouverage;
use App\Form\OuverageType;
use App\Repository\OuverageRepository;
use App\Service\UploaderHelper;
use App\Service\UploadType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/ouverage")
 */
class OuverageController extends AbstractController
{
    /**
     * @Route("/", name="app_ouverage_index", methods={"GET"})
     */
    public function index(Request $request, EntityManagerInterface $entityManager, PaginatorInterface $paginator): Response
    {
        /*
        $ouverages = $entityManager
            ->getRepository(Ouverage::class)
            ->findAll();
        */
        $queryBuilder = $entityManager->getRepository(Ouverage::class)->findAllQueryBuilder();
        $pagination = $paginator->paginate(
            $queryBuilder,
            $request->query->getInt('page', 1),
            5
        );
        return $this->render('ouverage/index.html.twig', [
            //'ouverages' => $ouverages,
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/new", name="app_ouverage_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager,
                        UploaderHelper $uploaderHelper): Response
    {
        $ouverage = new Ouverage();
        $form = $this->createForm(OuverageType::class, $ouverage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $form['ouverageImage']->getData();
            if ($uploadedFile) {
                $newFileName = $uploaderHelper->uploadFile($uploadedFile, 'OUVERAGE');
                $ouverage->setImgLivre($newFileName);
            }
            $entityManager->persist($ouverage);
            $entityManager->flush();
            $this->addFlash('success', 'Ouverage ajouté avec succès');

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
    public function edit(Request $request, Ouverage $ouverage, EntityManagerInterface $entityManager,
                         UploaderHelper $uploaderHelper): Response
    {
        $form = $this->createForm(OuverageType::class, $ouverage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $form['ouverageImage']->getData();
            if ($uploadedFile) {
                $newFileName = $uploaderHelper->uploadFile($uploadedFile, 'OUVERAGE');
                $ouverage->setImgLivre($newFileName);
            }
            $entityManager->flush();
            $this->addFlash('success', 'Ouverage modifié avec succès');

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
