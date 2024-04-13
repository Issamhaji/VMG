<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Car;
use App\Entity\Reservation;
use App\Voter\ListCarsVoter;
use App\Form\ReservationType;
use App\Voter\ReservationVoter;
use App\Repository\CarRepository;
use App\Repository\UserRepository;
use App\Service\ReservationService;
use Symfony\Component\Form\FormError;
use App\Repository\ReservationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReservationController extends AbstractController
{

    private ReservationService $reservationService;

    public function __construct(ReservationService $reservationService)
    {
        $this->reservationService = $reservationService;
    }

    #[Route('/reservation/{slug}', name: 'app_reservation')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function index(Request $request, ReservationRepository $reservationRepository, $slug, CarRepository $carRepository): Response
    {
        $user = $this->getUser();
        $car = $carRepository->findOneBy(['slug' => $slug]);

        $reservation = new Reservation();
        $reservation->setUser($user);
        $reservation->setCar($car);
        $form = $this->createForm(ReservationType::class, $reservation);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Check reservation conditions using the service reservationServ
            if ($this->reservationService->isReservationValid($reservation)) {
                
                $reservationRepository->save($reservation, true);
                $this->addFlash('green', 'reservation successfully');

                return $this->redirectToRoute('app_home');
            } else {
                $this->addFlash('red', 'date is not correct');
            }
        }
    

        return $this->render('reservation/index.html.twig', [
            'form' => $form->createView(),
            'car' => $car,
        ]);
    }

    #[Route('/list/{id}', name: 'app_list')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function listReservation(int $id, Request $request, ReservationRepository $reservationRepository, UserRepository $userRepository ): Response
    {
        $user = $userRepository->findOneBy(['id' => $id]);
        $list = $reservationRepository->findBy(['user' => $user]);
        //check if user has resv or not
        if (empty($list)) {
            $this->addFlash('green', 'you have no reservation');
            return $this->redirectToRoute('app_home');
        }
        // dd($list);
        
        foreach ($list as $reservation) {
            //use voter
            if($this->isGranted(ReservationVoter::VIEW, $reservation) === false ){
                $this->addFlash('green', 'you can not acces this list');
                return $this->redirectToRoute('app_home');
            }
        }
        

        // dd($list);
        return $this->render('reservation/list.html.twig', [
            'list' => $list,
        ]);
    }
}
