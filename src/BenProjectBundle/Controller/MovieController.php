<?php

// src/BenProjectBundle/Controller/MovieController.php

namespace BenProjectBundle\Controller;

use BenProjectBundle\Entity\Movie;
use BenProjectBundle\Form\MovieType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class MovieController extends Controller
{
    /**
     * @Route("/add", name="add")
     */
    public function addAction(Request $request)
    {
        $movie = new Movie();
        $form = $this->createForm(MovieType::class, $movie);
        $user = $this->getUser();
        $movie->setIdUser($user->getId());
        $movie->setUsername($user->getUsername());
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($movie);
            $em->flush();
            return $this->redirectToRoute('home');
        }

        return $this->render('BenProjectBundle:Movie:addMovie.html.twig', array('form' => $form->createView())
        );
    }

    /*
    * @ParamConverter("movie", options={"mapping": {"movie_id": "id"}})
    */
    public function modifyMovieAction(Movie $movie, Request $request)
    {
        $form = $this->createForm(MovieType::class, $movie);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($movie);
            $em->flush();
            return $this->redirectToRoute('home');
        }

        return $this->render('BenProjectBundle:Movie:modifyMovie.html.twig', array('form' => $form->createView())
        );
    }

    /*
    * @ParamConverter("movie", options={"mapping": {"movie_id": "id"}})
    */
    public function viewMovieAction(Movie $movie)
    {
        $title = $movie->getTitle();
        $date = $movie->getReleaseDate();
        $releaseDate = $date->format('d-m-Y');
        $synopsis = $movie->getSynopsis();
        $director = $movie->getDirector();

        return $this->render('BenProjectBundle:Movie:viewMovie.html.twig', array(
            'title' => $title,
            'releaseDate' => $releaseDate,
            'synopsis' => $synopsis,
            'director' => $director,
            'movie' => $movie,
        ));
    }

    public function viewAction()
    {
        $repository = $this
          ->getDoctrine()
          ->getManager()
          ->getRepository('BenProjectBundle:Movie')
        ;

        $listMovies = $repository->findAll();
        return $this->render('BenProjectBundle:Movie:view.html.twig', array(
            'listMovies' => $listMovies,
        ));
    }

    /*
    * @ParamConverter("movie", options={"mapping": {"movie_id": "id"}})
    */
    public function deleteMovieAction(Movie $movie)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($movie);
        $em->flush();
        return $this->redirectToRoute('movies_view');
    }
}
