<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AdminAccountController extends AbstractController
{
    /**
     * @Route("/admin/login", name="admin_account_login")
     */
    public function login(AuthenticationUtils $utils)
    {
         //Recuperation erreur
         $error = $utils->getLastAuthenticationError();
         //Recuperation du dernier nom d'utilisateur envoyé
         $username = $utils->getLastUsername();

        return $this->render('admin/account/login.html.twig', [
            'controller_name' => 'AdminAccountController',
            'hasError' => $error !== null,
            'username' => $username
        ]);
    }

    /**
     * @Route("/admin/logout", name="admin_account_logout")
     */
    public function logout()
    {
         
    }
}
