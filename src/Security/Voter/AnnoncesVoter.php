<?php

namespace App\Security\Voter;

use App\Entity\Annonces;
use App\Entity\Users;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class AnnoncesVoter extends Voter
{
    const ANNONCE_EDIT = 'annonce_edit';
    const ANNONCE_DELETE = 'annonce_delete';

    private $secutity;

    public function __construct(Security $security)
    {
        $this->secutity = $security;
    }

    protected function supports(string $attribute, $annonce): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::ANNONCE_EDIT, self::ANNONCE_DELETE])
            && $annonce instanceof \App\Entity\Annonces;
    }

    protected function voteOnAttribute(string $attribute, $annonce, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        //on verifie si l'utilisateur est admin
        if($this->secutity->isGranted("ROLE_ADMIN")) return true;

        if (null === $annonce->getUsers()) return false;

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::ANNONCE_EDIT:
                //on verifie si l'utilisateur peu editer
                return $this->canEdit($annonce, $user);

                break;
            case self::ANNONCE_DELETE:
                //on verifie si l'utilisateur peu supprimer
                return $this->canDelete();
                break;
        }

        return false;
    }

    private function canEdit(Annonces $annonce, Users $user) {
        //Le propretaire peu la modifier
        return $user === $annonce->getUsers();
    }

    private function canDelete() {
        //Le propretaire peu la supprimer
        if($this->secutity->isGranted("ROLE_ADMIN/ROLE_EDITOR")) return true;
        return false;
    }
}
