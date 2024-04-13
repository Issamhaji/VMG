<?php 

declare(strict_types=1);

namespace App\Tests\Service;

use App\Entity\Car;
use App\Entity\Reservation;
use PHPUnit\Framework\TestCase;
use App\Service\CarAvailability;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Collections\ArrayCollection;

class CarAvailabilityTest extends TestCase
{
    public function testIsCarAvailable(): void
    {
        // Mock EntityManager
        $entityManager = $this->createMock(EntityManagerInterface::class);

        // Create CarAvailability service with mocked dependencies
        $carAvailabilityService = new CarAvailability($entityManager);

        // Create a car with reservations
        $car = new Car();
        $reservation1 = new Reservation();
        $reservation2 = new Reservation();

        $now = new \DateTime();
        $reservation1->setDateEnd($now->modify('-1 day'));
        $reservation2->setDateEnd($now->modify('+1 day'));

        $car->addReservation($reservation1);
        $car->addReservation($reservation2);

        // Assert that the car is not available due to reservations
        $this->assertFalse($carAvailabilityService->isCarAvailable($car));

        // Remove reservations and assert that the car is now available
        $car->getReservations()->clear();
        $this->assertTrue($carAvailabilityService->isCarAvailable($car));
    }
}
