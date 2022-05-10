<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Ouverage;
use App\Entity\Users;
use App\Form\CommandeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/commande")
 */
class CommandeController extends AbstractController
{
    /**
     * @Route("/", name="app_commande_index", methods={"GET"})
     */
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $userid= $request->getSession()->get('idUser');
        $client=$this->getDoctrine()->getRepository(Users::class)->find($userid);
        $commandes = $entityManager
            ->getRepository(Commande::class)
            ->findOneBy(
                [
                    'idUser'=>$client->getIdUser() ,

                ]);


        return $this->render('commande/index.html.twig', [
            'commandes' => $commandes,
            'ouverages' => $commandes->getIdOuvrage(),

        ]);
    }

    /**
     * @Route("/new", name="app_commande_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager ): Response
    { $id_livre=3;
        $ouverage=$this->getDoctrine()->getRepository(Ouverage::class)->find($id_livre);
        $userid= $request->getSession()->get('idUser');
        $client=$this->getDoctrine()->getRepository(Users::class)->find($userid);
$commande= $this->getDoctrine()->getRepository(Commande::class )->findOneBy(
    [
    'idUser'=>$client->getIdUser() ,
    'etat'=>0,
]);

if ($commande != null )
{
    $commande->addIdOuvrage($ouverage);
    $commande->setPrixTotal($commande->getPrixTotal()+$ouverage->getPrixVente());
    $entityManager->flush();
}
else
{
    $commande1= new Commande();
    $commande1->setPrixTotal($ouverage->getPrixVente());
    $commande1->setIdUser($client);
    $commande1->setEtat(0);
    $commande1->addIdOuvrage($ouverage);
    $entityManager->persist($commande1);
    $entityManager->flush();
}

        return $this->render('home_page/HomePageClient.html.twig');
    }

    /**
     * @Route("/{idCommande}/{id}", name="app_commande_show", methods={"GET"})
     */
    public function show(Commande $commandes , Ouverage $ouverage,EntityManagerInterface $entityManager ): Response
    { $commandes->removeIdOuvrage($ouverage);
        $entityManager->flush();

        return $this->render('commande/index.html.twig', [
            'commandes' => $commandes,
            'ouverages' => $commandes->getIdOuvrage(),

        ]);
    }

    /**
     * @Route("/checkout", name="app_commande_checkout", methods={"GET"})
     */
    public function payer(Request $request): Response
    {
        return $this->render('commande/checkout.html.twig');
    }

    /**
     * @Route("/{idCommande/{idouvrage}", name="app_commande_supp", methods={"GET"})
     */
    public function supprimerouvrage(Commande $commande): Response
    {
        return $this->render('commande/show.html.twig', [
            'commande' => $commande,
        ]);
    }


    /**
     * @Route("/{idCommande}/edit", name="app_commande_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Commande $commande, EntityManagerInterface $entityManager): Response
    {
        return $this->render('commande/checkout.html.twig');
    }

    /**
     * @Route("/{idCommande}", name="app_commande_delete", methods={"POST"})
     */
    public function delete(Request $request, Commande $commande, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commande->getIdCommande(), $request->request->get('_token'))) {
            $entityManager->remove($commande);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_commande_index', [], Response::HTTP_SEE_OTHER);
    }
}
