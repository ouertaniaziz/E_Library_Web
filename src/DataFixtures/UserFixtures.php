<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends BaseFixtures
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /*
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
    */
    public function loadData(ObjectManager $em): void
    {
        $this->createNew(10, 'main_user', function ($count) use ($em) {
            $user = new User();
            $user->setNomUser($this->faker->lastName);
            $user->setPrenomUser($this->faker->firstName);
            //$user->setEmail($this->faker->randomElement(self::$firstnames) . $this->faker->randomElement(self::$lastnames) . '@example.com');

            $user->setEmail($this->faker->email);
            $user->setMdpUser(
                $this->passwordEncoder->encodePassword(
                    $user, '123123'));

            return $user;
        });

        $this->createNew(1, 'admin_user', function ($count) use ($em) {
            $user = new User();
            $user->setNomUser("Azzebi");
            $user->setPrenomUser("Mehdi");

            $user->setEmail("mohamedmehdi.azzabi@esprit.tn");
            $user->setMdpUser(
                $this->passwordEncoder->encodePassword(
                    $user, '123123'));
            $user->setRoles(['ROLE_ADMIN']);
            return $user;
        });

        $em->flush();

    }
}
