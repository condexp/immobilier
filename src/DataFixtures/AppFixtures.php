<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Bien;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $faker = Factory::create('fr_FR');
        // create 20 biens! Bam!
        for ($i = 0; $i < 20; $i++) {
            $bien = new Bien();

            $bien->setDescriptions($faker->sentences(3, true))
                ->setAdresse($faker->address)
                ->setPrix($faker->numberBetween(10000, 1000000))
                ->setTitre($faker->words(10, true))
                ->setSurface($faker->numberBetween(20, 350))
                ->setNbrepieces($faker->numberBetween(1, 10))
                ->setNbrechambres($faker->numberBetween(1, 10))
                ->setAdresse($faker->address)
                ->setCodepostale($faker->postcode)
                ->setVendu(false)
                ->setVille($faker->city);
            $manager->persist($bien);
        }

        $manager->flush();
    }
}
