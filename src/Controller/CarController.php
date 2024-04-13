<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\CarAvailability;
use App\Repository\CarRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CarController extends AbstractController
{
    private CarAvailability $carAvailabilityService;

    public function __construct(CarAvailability $carAvailabilityService)
    {
        $this->carAvailabilityService = $carAvailabilityService;
    }

    #[Route('/', name: 'app_home')]
    public function index(CarRepository $carRepository): Response
    {
        $cars = $carRepository->findAll();

        $availability = [];

        foreach ($cars as $car) {
            //use service
            $availability[$car->getId()] = $this->carAvailabilityService->isCarAvailable($car);
        }

        return $this->render('home/index.html.twig', [
            'cars' => $cars,
            'availability' => $availability,
        ]);
    }

    #[Route('/cars/{slug}', name: 'app_car')]
    public function carsDetails(CarRepository $carRepository, Request $request): Response
    {
        $slug = $request->attributes->get('slug');
        $car = $carRepository->findOneBy(['slug'=> $slug]);

        $availability[$car->getId()] =  $this->carAvailabilityService->isCarAvailable($car);

        return $this->render('home/details.html.twig', [
            'car' => $car,
            'availability' => $availability,
        ]);
    }
}
