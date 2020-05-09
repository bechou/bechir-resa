<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AccountController extends AbstractController
{
    /**
     * @Route("/login", name="account_login")
     */
    public function login(AuthenticationUtils $utils)
    {
        //Recuperation erreur
        $error = $utils->getLastAuthenticationError();
        //Recuperation du dernier nom d'utilisateur envoyé
        $username = $utils->getLastUsername();
       
        return $this->render('account/login.html.twig', [
            'hasError' => $error !== null,
            'username' => $username
        ]);
    }

    /**
     * @Route("/logout", name="account_logout")
     */
    public function logout()
    {
        
    }

    /**
     * @Route("/register", name="account_register")
     */
    public function register()
    {
        $user = new User();

        $form = $this->createForm(RegistrationType::class, $user);
        
        return $this->render('account/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
