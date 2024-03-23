<?php

namespace App\Security\Voter;

use App\Entity\Picture;
use App\Entity\User;
use App\Entity\UserPicture;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class PictureVoter extends Voter
{
    const EDIT = 'edit';

    /**
     * @inheritDoc
     */
    protected function supports(string $attribute, mixed $subject): bool
    {
        if (!in_array($attribute, [self::EDIT])) {
            return false;
        }

        if (!$subject instanceof Picture) {
            return false;
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            //l'utilisateur doit être connecté
            return false;
        }

        /** @var Picture $picture */
        $picture = $subject;

        return match($attribute) {
            self::EDIT => $this->canEdit($picture, $user),
            default => throw new \LogicException('This code should not be reached')
        };

    }
    private function canEdit(Picture $picture, User $user): bool
    {
        return $picture->getUserPictures()->exists(
            function ($key, UserPicture $userPicture) use ($user) {
                return $userPicture->getCollector() === $user;
            }
        );
    }

}
