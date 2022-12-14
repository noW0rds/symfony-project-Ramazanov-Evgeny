<?php

namespace App\Security\Voter;

use App\Entity\PersonalCheck;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class PersonalCheckVoter extends Voter
{
    public const NEW = 'new';
    public const SHOW = 'show';
    public const EDIT = 'edit';
    public const DELETE = 'delete';

    protected function supports(string $attribute, $subject): bool
    {
        return in_array($attribute, [self::NEW, self::SHOW, self::EDIT, self::DELETE])
            && $subject instanceof PersonalCheck;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        $personalCheck = $subject;
        switch ($attribute) {
            case self::SHOW:
            case self::NEW:
                return (in_array('ROLE_USER', $user->getRoles())
                    or in_array('ROLE_ADMIN', $user->getRoles()));

            case self::EDIT:
                return $this->canEdit($personalCheck, $user);

            case self::DELETE:
                return $this->canDelete($personalCheck, $user);

        }

        return false;
    }

    private function canDelete(PersonalCheck $personalCheck, User $user): bool
    {
        if (in_array('ROLE_ADMIN', $user->getRoles()) or $user === $personalCheck->getWhoAuthor()) {
            return true;
        }
        return false;
    }

    private function canEdit(PersonalCheck $personalCheck, User $user): bool
    {
        if (in_array('ROLE_ADMIN', $user->getRoles()) or $user === $personalCheck->getWhoAuthor()) {
            return true;
        }
        return false;
    }
}