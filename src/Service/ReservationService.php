<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Car;
use App\Entity\Reservation;
use App\Repository\CarRepository;
use App\Repository\ReservationRepository;
use Symfony\Component\Form\FormInterface;

class ReservationService
{
    private CarAvailability $carAvailability;
    private CarRepository $carRepository;
    private ReservationRepository $reservationRepository;

    public function __construct(
        CarAvailability $carAvailability,
        CarRepository $carRepository,
        ReservationRepository $reservationRepository
    ) {
        $this->carAvailability = $carAvailability;
        $this->carRepository = $carRepository;
        $this->reservationRepository = $reservationRepository;
    }

    public function isReservationValid(Reservation $reservation): bool
{
    //new date
    $now = new \DateTime();

    // Check if dateStart is less than dateEnd
    if ($reservation->getDateStart() < $reservation->getDateEnd()) {
        // Check if dateStart is greater than or equal to the current date
        if ($reservation->getDateStart() >= $now) {
            return true; 
        }
    }

    return false; 
}

}
