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

    private static $auteur_photos = [
        "photo1.jpg",
        "photo2.jpeg",
        "photo3.jpeg",
        "photo4.jpeg",
        "photo5.jpeg",
        "photo6.jpeg",
        "photo7.jpeg"
    ];

    protected function loadData(ObjectManager $em): void
    {
        $this->createNew(10, 'main_auteurs', function($count) use ($em) {

            $auteur = new Auteur();
            $auteur->setNomAuteur($this->faker->lastName);
            $auteur->setPrenomAuteur($this->faker->randomElement(self::$firstnames));
            $auteur->setPhotoAuteur($this->faker->randomElement(self::$auteur_photos));
            return $auteur;
        });
        $em->flush();
    }
}
