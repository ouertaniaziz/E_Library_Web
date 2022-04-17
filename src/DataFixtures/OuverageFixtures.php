<?php

namespace App\DataFixtures;

use App\Entity\Ouverage;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class OuverageFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for($i = 0; $i < 10; $i++) {
            $ouverage = new Ouverage();
            $ouverage->setNomLivre('Exemple Titre');
            $ouverage->setImgLivre('');
            $ouverage->setAuteur();
            $manager->persist($ouverage);
        }
        $manager->flush();
    }
}
