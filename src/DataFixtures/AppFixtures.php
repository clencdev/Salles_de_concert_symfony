<?php

namespace App\DataFixtures;

use App\Entity\Actu;
use App\Entity\Event; 
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    private const NB_ACTU = 12;
    private const NB_EVENT = 13;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create("fr_FR");

        $admin = new User();
        $admin
            ->setUsername('Admin')
            ->setPassword('abc123')
            ->setRoles(['ROLE_ADMIN']);

        $manager->persist($admin);

        for ($i = 0; $i < self::NB_ACTU; $i++) {
            $actu = new Actu();
            $actu
                ->setTitle($faker->realTextBetween(3, 10))
                ->setTextContent($faker->realTextBetween(500, 1400));

            $manager->persist($actu);
        }

        for ($i = 0; $i < self::NB_EVENT; $i++) {
            $event = new Event();
            $event
                ->setEventName($faker->realTextBetween(3, 10))
                ->setDescription($faker->realTextBetween(500, 1400))
                ->setEventDate($faker->dateTimeBetween('2023-12-23', '2024-01-24')); 

            $manager->persist($event);

        }

        $manager->flush(); 
    }
}
