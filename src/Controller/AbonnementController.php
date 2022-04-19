<?php

namespace App\Controller;

use App\Entity\Abonnement;
use App\Entity\Offre;
use App\Entity\Users;
use App\Form\AbonnementType;
use Doctrine\ORM\EntityManagerInterface;
use http\Client;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;
/**
 * @Route("/abonnement")
 */
class AbonnementController extends AbstractController
{
    /**
     * @Route("/", name="app_abonnement_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager, PaginatorInterface $paginator, Request $request): Response
    {

        $donnees = $entityManager
            ->getRepository(Abonnement::class)
            ->findAll();
        $abonnements=$paginator->paginate(
            $donnees, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            3// Nombre de résultats par page
        );


        return $this->render('abonnement/index.html.twig', [
            'abonnements' => $abonnements,
        ]);
    }

    /**
     * @Route("/new/{id_client}/{id_offre}", name="app_abonnement_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager ,$id_client,$id_offre, ): Response
    {    $offre = new offre();
        $client = new Users();
        $abonnement = new Abonnement();
        $client=$this->getDoctrine()->getRepository(Users::class)->find($id_client);
        $offre = $this->getDoctrine()
            ->getRepository(Offre::class)
            ->find($id_offre);
       $jeton=$offre->getNbrJetonOffre();
     $abonnement->setIdUser($client);
       $abonnement->setNbrJetonAbonnement($jeton);
       $abonnement->setSolde($jeton);
        $abonnement->setIdOffre($offre);


            $entityManager->persist($abonnement);
            $entityManager->flush();
        #########################  Test QrCode ##################################
        $result = Builder::create()
            ->writer(new PngWriter())
            ->writerOptions([])
            ->data('contenu de Qr code  ')
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
            ->size(300)
            ->margin(10)
            ->roundBlockSizeMode(new RoundBlockSizeModeMargin())

            ->labelText('abonnement ')
            ->labelFont(new NotoSans(20))
            ->labelAlignment(new LabelAlignmentCenter())
            ->build();

// Directly output the QR code
      //  header('Content-Type: '.$result->getMimeType());
      //  echo $result->getString();

// Save it to a file
        $result->saveToFile(__DIR__.'/qrcode1.png');

// Generate a data URI to include image data inline (i.e. inside an <img> tag)
      //  $dataUri = $result->getDataUri();
####################### Fin test #################################



        return $this->redirectToRoute('app_offre_AccueilClient', [], Response::HTTP_SEE_OTHER);


    }

    /**
     * @Route("/{idAbonnement}", name="app_abonnement_show", methods={"GET"})
     */
    public function show(Abonnement $abonnement): Response
    {
        return $this->render('abonnement/show.html.twig', [
            'abonnement' => $abonnement,
        ]);
    }

    /**
     * @Route("/{idAbonnement}/edit", name="app_abonnement_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Abonnement $abonnement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AbonnementType::class, $abonnement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_abonnement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('abonnement/edit.html.twig', [
            'abonnement' => $abonnement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idAbonnement}", name="app_abonnement_delete", methods={"POST"})
     */
    public function delete(Request $request, Abonnement $abonnement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$abonnement->getIdAbonnement(), $request->request->get('_token'))) {
            $entityManager->remove($abonnement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_abonnement_index', [], Response::HTTP_SEE_OTHER);
    }
}
