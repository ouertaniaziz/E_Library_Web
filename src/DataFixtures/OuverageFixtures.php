<?php

namespace App\DataFixtures;

use App\Entity\Auteur;
use App\Entity\Ouverage;
use App\Repository\AuteurRepository;
use Doctrine\Persistence\ObjectManager;
use JetBrains\PhpStorm\NoReturn;

class OuverageFixtures extends BaseFixtures
{
    private static $ouverageTitles = [
        'Why Asteroids Taste Like Bacon',
        'Life on Planet Mercury',
        'Relaxing and Fabulous',
        'Light Speed Travel',
        'Fountain of Youth or Fallacy',
    ];

    private static $ouverageImages = [
        'asteroid.jpeg',
        'mercury.jpeg',
        'lightspeed.png',
    ];

    private static $ouverageAuteurs = [
        'Mike Ferengi',
        'Amy Oort',
        'Kevin Anderson',
        'Ali Douagi'
    ];
    private static $ouveragePrix = [
        50,
        55,
        60,
        65
    ];
    private static $ouvrageEmprunt = [
        10,
        15,
        20,
        25,
        30
    ];
    private static $ouvrageGenre = [
        'Thriller',
        'Fantasy',
        'Documentary',
        'Love Story'
    ];
    #[NoReturn] protected function loadData(ObjectManager $em): void
    {
        $auteurs = $em->getRepository(Auteur::class)->findAll();
        for($i = 0; $i < 10; $i++) {
            $ouverage = new Ouverage();
            $ouverage->setNomLivre($this->faker->randomElement(self::$ouverageTitles));
            $ouverage->setImgLivre($this->faker->randomElement(self::$ouverageImages));
            $ouverage->setAuteur($this->faker->randomElement($auteurs));
            $ouverage->setGenreLivre($this->faker->randomElement(self::$ouvrageGenre));
            $ouverage->setPrixEmprunt($this->faker->numberBetween(20, 90));
            $ouverage->setPrixVente($this->faker->numberBetween(100,500));
            $em->persist($ouverage);
        }
        $em->flush();
    }

    public function getDependencies(): array
    {
        return [AuteurFixtures::class];
    }
}
