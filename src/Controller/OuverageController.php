<?php

namespace App\Controller;

use App\Entity\Ouverage;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
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
}