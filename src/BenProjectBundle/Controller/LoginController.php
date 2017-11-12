<?php

namespace BenProjectBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request, AuthenticationUtils $authUtils)
    {
    	$errors = $authUtils->getLastAuthenticationError();
    	$lastUsername = $authUtils->getLastUsername();
        return $this->render('BenProjectBundle:Login:login.html.twig', array(
        	'errors' => $errors,
        	'last_username' => $lastUsername,
        ));
        return $this->redirectToRoute('home');
    }

    /*
    ** @Route("/logout", name="logout")
    */
    public function logoutAction ()
    {
    }

}
