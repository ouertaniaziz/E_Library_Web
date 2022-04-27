<?php

namespace App\Controller;

use App\Entity\Abonnement;
use App\Entity\Emprunt;
use App\Entity\Ouverage;
use App\Entity\Users;
use App\Form\EmpruntType;
use Doctrine\ORM\EntityManagerInterface;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
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
        $emprunts=$paginator->paginate(
            $donnees, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            3// Nombre de résultats par page
        );

        return $this->render('emprunt/index.html.twig', [
            'emprunts' => $emprunts,
        ]);
    }

    /**
     * @Route("/new/{id_livre}/{nbr_semaine}", name="app_emprunt_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager, $nbr_semaine,$id_livre ,MailerInterface $mailer): Response
    {    $abonnement=new Abonnement();
        $ouverage=new Ouverage();
        $user= new Users();
        $userid= $request->getSession()->get('idUser');
        $user=$this->getDoctrine()->getRepository(Users::class)->find($userid);
        $ouverage=$this->getDoctrine()->getRepository(Ouverage::class)->find($id_livre);
        $abonnement=$this->getDoctrine()->getRepository(Abonnement::class)->findOneBy(

            ['idUser' => $userid]);


        $emprunt = new Emprunt();
     $emprunt->setIdOuvrage($ouverage);
     $emprunt->setDateEmprunt(new \DateTime('now'));
    # $emprunt->setDateRetourOuvrage(strtotime("+1 week")); attentionn il faut terminer cette configuration de date
        $emprunt->setDateRetourOuvrage(new \DateTime('now'));
$emprunt->setIdAbonnement($abonnement->getIdAbonnement());
$abonnement-> setSolde($abonnement->getSolde()-($ouverage->getPrixEmprunt()*$nbr_semaine));
$ouverage->setNbrEmprunt($ouverage->getNbrEmprunt()+1);

        #########################  Test QrCode ##################################
        $result = Builder::create()
            ->writer(new PngWriter())
            ->writerOptions([])
            ->data("bonjour  ".$user->getNomUser()."\n votre avez emprunter le livre ".$ouverage->getNomLivre()."\n de la date " .$emprunt->getDateEmprunt()->format('Y-m-d H:i:s')." \njusqu'a " .$emprunt->getDateRetourOuvrage()->format('Y-m-d H:i:s') . " \nvous pouvez recuperer votre ouverage en utilisant ce code Qr de la librairie la prus proche de vous .")
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
            ->size(300)
            ->margin(10)
            ->roundBlockSizeMode(new RoundBlockSizeModeMargin())

            ->labelText($ouverage->getNomLivre())
            ->labelFont(new NotoSans(20))
            ->labelAlignment(new LabelAlignmentCenter())
            ->build();



// Save it to a file
        $result->saveToFile(__DIR__.'/qrcode_emprunt.png');

####################### Fin test #################################
        $email = (new TemplatedEmail());
        $emprunt->sendQREMPRUNT($mailer ,$user->getEmailUser());
          $entityManager->persist($emprunt);
        $entityManager->flush();
            return $this->redirectToRoute('app_home_page_client', [], Response::HTTP_SEE_OTHER);


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
        if ($this->isCsrfTokenValid('delete'.$emprunt->getIdEmprunt(), $request->request->get('_token'))) {
            $entityManager->remove($emprunt);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_emprunt_index', [], Response::HTTP_SEE_OTHER);
    }
}
