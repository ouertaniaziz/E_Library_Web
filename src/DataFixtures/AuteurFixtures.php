<?php

namespace App\DataFixtures;

use App\Entity\Auteur;
use Doctrine\Persistence\ObjectManager;
use phpDocumentor\Reflection\Types\Self_;

class AuteurFixtures extends BaseFixtures
{
    private static $lastnames = [
        "Herring",
        "Lowery",
        "Rodriguez",
        "Fitzgerald",
        "Collier",
        "Landry",
        "Pierce",
        "Knight",
        "Rios",
        "Cook",
        "Owens",
        "Ellis"
    ];
    private static $firstnames = [
        "Teagan",
        "Emiliano",
        "Alyson",
        "Zoey",
        "Charlotte",
        "Roman",
        "Brett",
        "Frankie",
        "Marcos",
        "Makhi",
        "Noelle",
        "Ralph"
    ];


    protected function loadData(ObjectManager $em): void
    {
        for ($i = 0; $i <= 20; $i++) {
            $auteur = new Auteur();
            $auteur->setNomAuteur($this->faker->randomElement(self::$lastnames));
            $auteur->setPrenomAuteur($this->faker->randomElement(self::$firstnames));
            $auteur->setPhotoAuteur("");
            $em->persist($auteur);
        }
        $em->flush();

    }
}
