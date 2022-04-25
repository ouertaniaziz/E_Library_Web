<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

abstract class BaseFixtures extends Fixture
{
    /** @var ObjectManager */
    private ObjectManager $manager;

    /** @var Generator */
    protected Generator $faker;
    abstract protected function loadData(ObjectManager $em);


    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;
        $this->faker = Factory::create("fr_FR");
        $this->loadData($manager);
    }

    protected function createMany(string $className, int $count, callable $factory)
    {
        for ($i = 0; $i < $count; $i++)
        {
            $entity = new $className();
            $factory($entity, $i);
            $this->manager->persist($entity);
            // save pour utiliser apres : ClassName_COUNT
            $this->addReference($className.'_'.$i, $entity);
        }
    }
}