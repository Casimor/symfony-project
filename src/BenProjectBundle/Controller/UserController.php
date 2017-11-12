<?php

// src/BenProjectBundle/Controller/UserController.php

namespace BenProjectBundle\Controller;

use BenProjectBundle\Entity\User;
use BenProjectBundle\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends Controller
{
    /**
     * @Route("/register", name="user_registration")
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setRoles(array("ROLE_USER"));
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('login');
        }

        return $this->render('BenProjectBundle:User:register.html.twig', array('form' => $form->createView())
        );
    }

    /**
     * @Route("/register", name="user_registration")
     */
    public function createAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setRoles(array("ROLE_USER"));
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('users_view');
        }

        return $this->render('BenProjectBundle:User:create.html.twig', array('form' => $form->createView())
        );
    }

    /**
     * @Route("/user", name="users_view")
     */
    public function viewAction()
    {
        $repository = $this
          ->getDoctrine()
          ->getManager()
          ->getRepository('BenProjectBundle:User')
        ;

        $listUsers = $repository->findAll();
        return $this->render('BenProjectBundle:User:view.html.twig', array(
            'listUsers' => $listUsers,
        ));
    }

    /*
    * @ParamConverter("user", options={"mapping": {"user_id": "id"}})
    */
    public function modifyUserAction(User $user, Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('BenProjectBundle:User:modifyUser.html.twig', array('form' => $form->createView())
        );
    }

    /*
    * @ParamConverter("user", options={"mapping": {"user_id": "id"}})
    */
    public function deleteUserAction(User $user)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();
        return $this->redirectToRoute('users_view');
    }
}
