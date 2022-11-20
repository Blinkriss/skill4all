<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Car;
use App\Entity\CarCategory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        $faker->addProvider(new \Faker\Provider\Car($faker));

        for ($cc = 0; $cc < 5; $cc++) {
            $carCategory = new CarCategory;

            $carCategory->setName($faker->carCategory());

            $manager->persist($carCategory);

            for ($c = 0; $c < mt_rand(40, 50); $c++) {
                $car = new Car;

                $car->setName($faker->car())
                    ->setNbSeats($faker->numberBetween(1, 8))
                    ->setNbDoors($faker->numberBetween(2, 10))
                    ->setCost($faker->randomNumber(5, true))
                    ->setCarCategory($carCategory);

                $manager->persist($car);
            }
        }

        $manager->flush();
    }
}
