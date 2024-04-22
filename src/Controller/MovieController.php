<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Movie;
use App\Form\MovieType;
use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Controller for adding, displaying movie data.
 */
class MovieController extends AbstractController {

  private MovieRepository $movieRepository;
  public function __construct(MovieRepository $movieRepository)
  {
    $this->movieRepository = $movieRepository;
  }

  /**
   * Returns all movies stored in database.
   *
   * @return \Symfony\Component\HttpFoundation\Response
   *   Returns all movies stored in database.
   */
  #[Route('/movies', name: 'list-movie')]
  public function getMovies():Response {
    $movies = $this->movieRepository->findAll();
    return $this->render('movie/index.html.twig',[
      'movies' => $movies
    ]);
  }

  /**
   * Displays single movie data by using movie id.
   *
   * @param int $id
   *   Movie ID.
   *
   * @return \Symfony\Component\HttpFoundation\Response
   *   Displays a single movie.
   */
  #[Route('/movies/read-more/{id}', name: 'show-movie',format: 'int')]
  public function getOneMovie(int $id):Response {
    $movie = $this->movieRepository->find($id);
    return $this->render('movie/show-movie.html.twig',[
      'movie' => $movie
    ]);
  }

  /**
   * Takes movie details from user using form interface and stores the movie
   * data in database.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   Takes Request object to handle the requests from form.
   *
   * @return \Symfony\Component\HttpFoundation\Response
   *   Returns a form view to put movie data.
   */
  #[Route('/movies/add', name: 'add-movie')]
  public function addMovie(Request $request):Response {
    $movie = new Movie();
    $form = $this->createForm(MovieType::class, $movie);
    $form->handleRequest($request);
    if($form->isSubmitted() && $form->isValid()) {
      $movie = $form->getData();
      $imagePath =$form->get('thumbnail')->getData();
      if($imagePath){
        $newFileName = uniqid() . '.' .$imagePath->guessExtension();
        try {
          $imagePath->move(
            $this->getParameter('kernel.project_dir') . '/public/uploads/movies',
            $newFileName
          );
        }catch (FileException $exception){
          return new Response($exception->getMessage());
        }
        $movie->setThumbnail('/uploads/movies/' . $newFileName);
      }
      $this->movieRepository->save($movie);
      $this->addFlash('success', 'Movie added successfully');
      return $this->redirectToRoute('list-movie');
    }
    return $this->render('movie/add.html.twig',[
      'form' => $form->createView()
    ]);
  }
}
