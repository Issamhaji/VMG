<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Car;
use Doctrine\ORM\EntityManagerInterface;

class CarAvailability
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function isCarAvailable(Car $car): bool
    {
        $latestDateEnd = null;

        foreach ($car->getReservations() as $reservation) {
            $dateEnd = $reservation->getDateEnd();
            // set latest dateEnd
            if ($latestDateEnd === null || $dateEnd > $latestDateEnd) {
                $latestDateEnd = $dateEnd;
            }
        }

        $now = new \DateTime();

        return $latestDateEnd === null || $latestDateEnd < $now;
    }
}