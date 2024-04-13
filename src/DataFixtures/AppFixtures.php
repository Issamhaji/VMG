<?php
declare(strict_types=1);

namespace App\DataFixtures;

use App\Factory\CarFactory;
use App\Factory\ReservationFactory;
use App\Factory\UserFactory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    private const COUNT_CARS = 4;
    private const COUNT_RESERVATIONS = 20;

    private const COUNT_USERS = 10;

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        CarFactory::createMany(self::COUNT_CARS);

        UserFactory::createMany(self::COUNT_USERS);

        

        

        $manager->flush();
    }
}
