<?php

namespace App\DataFixtures;

use App\Entity\Auteur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AuteurFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for($i = 0; $i < 10; $i++) {
            $auteur = new Auteur();
            $auteur->setNomAuteur('Shakespeare');
            $auteur->setPrenomAuteur('William');
            $auteur->setPhotoAuteur("");
            $manager->persist($auteur);
        }
        $manager->flush();

    }
}
