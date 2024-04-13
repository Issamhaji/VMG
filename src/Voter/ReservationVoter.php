<?php
declare(strict_types=1);

namespace App\Voter;

use App\Entity\User;
use App\Entity\Article;

use App\Entity\Reservation;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class ReservationVoter extends Voter
{
    public  const VIEW = 'view';

    public function __construct(private readonly Security $security)
    {
    }

    protected function supports(string $attribute, mixed $subject): bool
    {
       return $subject instanceof Reservation && $attribute === self::VIEW;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        $reservation = $subject;

        if (!$user instanceof User) {
            return false;
        }
        //check if user_id of reservation equal login user
        return $user->getId() === $reservation->getUser()->getId();

    }

}
