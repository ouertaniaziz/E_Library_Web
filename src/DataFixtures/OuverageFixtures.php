<?php

namespace App\DataFixtures;

use App\Entity\Auteur;
use App\Entity\Ouverage;
use Doctrine\Persistence\ObjectManager;

class OuverageFixtures extends BaseFixtures
{
    protected function loadData(ObjectManager $manager): void
    {
        for($i = 0; $i < 10; $i++) {
            $ouverage = new Ouverage();
            $auteur = new Auteur();
            $auteur->setNomAuteur('Shakespeare');
            $auteur->setPrenomAuteur('William');
            $auteur->setPhotoAuteur("");
            $manager->persist($auteur);
            $ouverage->setNomLivre('Exemple Titre');
            $ouverage->setImgLivre('');
            $ouverage->setAuteur($auteur);
            $ouverage->setGenreLivre('SciFi');
            $ouverage->setPrixEmprunt(10);
            $ouverage->setPrixVente(100);
            $manager->persist($ouverage);
        }
        $manager->flush();
    }
}
