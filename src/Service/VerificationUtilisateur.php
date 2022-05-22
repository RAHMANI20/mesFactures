<?php

namespace App\Service;

use App\Entity\Users;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

class VerificationUtilisateur extends AbstractController
{
    public function userIsValide($email,$password,$currentPassword,$newPassword,$confirmNewPassword){

        $valide = true;

        if ($email == ""){
            $this->addFlash('emailError','doit être rempli(e)');
            $valide = false;
        }

        if ($currentPassword === ""){
            $this->addFlash('currentPasswordError','doit être rempli(e)');
            $valide = false;
        } else if(password_verify($currentPassword,$password) === false){
            $this->addFlash('currentPasswordError','n\'est pas valide');
            $valide = false;
        }

        if($newPassword !== "" && $newPassword !== $confirmNewPassword){
            $this->addFlash('confirmNewPasswordError','ne concorde pas avec Mot de passe');
            $valide = false;
        }

        if($newPassword === "" && $confirmNewPassword !== "" ){
            $this->addFlash('newPasswordError','doit être rempli(e)');
            $this->addFlash('confirmNewPasswordError','ne concorde pas avec Mot de passe');
            $valide = false;
        }

        return $valide;

    }



}