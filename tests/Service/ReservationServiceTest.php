<?php 
declare(strict_types=1);

namespace App\Tests\Service;

use App\Entity\Car;
use App\Entity\Reservation;
use App\Repository\CarRepository;
use App\Repository\ReservationRepository;
use App\Service\CarAvailability;
use App\Service\ReservationService;
use PHPUnit\Framework\TestCase;

class ReservationServiceTest extends TestCase
{
    public function testIsReservationValid(): void
    {
        // Mock CarAvailability service
        $carAvailability = $this->createMock(CarAvailability::class);

        // Mock CarRepository
        $carRepository = $this->createMock(CarRepository::class);

        // Mock ReservationRepository
        $reservationRepository = $this->createMock(ReservationRepository::class);

        // Create ReservationService with mocked dependencies
        $reservationService = new ReservationService($carAvailability, $carRepository, $reservationRepository);

        // Create a reservation with valid dates
        $reservation = new Reservation();
        $now = new \DateTime();
        $reservation->setDateStart($now);
        $reservation->setDateEnd($now->modify('+1 day'));

        // Assert that the reservation is valid
        $this->assertTrue($reservationService->isReservationValid($reservation));

        // Create a reservation with invalid dates
        $invalidReservation = new Reservation();
        $invalidReservation->setDateStart($now);
        $invalidReservation->setDateEnd($now->modify('-1 day'));

        // Assert that the reservation is not valid
        $this->assertFalse($reservationService->isReservationValid($invalidReservation));
    }
}