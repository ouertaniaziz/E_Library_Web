<?php

namespace App\DataFixtures;

use App\Entity\Auteur;
use Doctrine\Persistence\ObjectManager;

class AuteurFixtures extends BaseFixtures
{
    protected function loadData(ObjectManager $manager): void
    {
        $this->createMany(Auteur::class, 10, function(Auteur $auteur, $count){
            $auteur->setNomAuteur('Shakespeare');
            $auteur->setPrenomAuteur('William');
            $auteur->setPhotoAuteur("");
        });


        $manager->flush();

    }
}
