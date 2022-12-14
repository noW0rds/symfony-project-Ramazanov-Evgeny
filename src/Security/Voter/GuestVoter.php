<?php

namespace App\Security\Voter;

use App\Entity\Guest;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class GuestVoter extends Voter
{
    public const NEW = 'new';
    public const SHOW = 'show';
    public const EDIT = 'edit';
    public const DELETE = 'delete';

    protected function supports(string $attribute, $subject): bool
    {
        return in_array($attribute, [self::NEW, self::SHOW, self::EDIT, self::DELETE])
            && $subject instanceof Guest;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        if (!$user instanceof UserInterface) {
            return false;
        }

        $guest = $subject;

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::SHOW:
            case self::NEW:
                return (in_array('ROLE_USER', $user->getRoles())
                    or in_array('ROLE_ADMIN', $user->getRoles()));

            case self::EDIT:
                return $this->canEdit($guest, $user);

            case self::DELETE:
                return $this->canDelete($guest, $user);

        }

        return false;
    }

    private function canDelete(Guest $guest, User $user): bool
    {
        if (in_array('ROLE_ADMIN', $user->getRoles()) or $user === $guest->getWhoAuthor()) {
            return true;
        }
        return false;
    }

    private function canEdit(Guest $guest, User $user): bool
    {
        if (in_array('ROLE_ADMIN', $user->getRoles()) or $user === $guest->getWhoAuthor()) {
            return true;
        }
        return false;
    }
}