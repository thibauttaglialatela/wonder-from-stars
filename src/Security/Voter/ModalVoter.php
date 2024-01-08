<?php

namespace App\Security\Voter;

use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class ModalVoter extends Voter
{
    public function __construct(private Security $security)
    {
    }


    protected function supports(string $attribute, mixed $subject): bool
    {
        return $attribute === 'ACCESS_MODAL';
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        if ($this->security->isGranted('ROLE_USER')) {
            return true;
        }

        return false;


    }
}
