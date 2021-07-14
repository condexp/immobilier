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

        // create 20 biens! Bam!


        $manager->flush();
    }
}
