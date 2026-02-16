<?php

namespace App\Controller;

use App\Entity\Film;
use App\Repository\FilmRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FilmController extends AbstractController
{
    #[Route('/films', name: 'app_films')]
    public function index(FilmRepository $filmRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $query = $filmRepository->createQueryBuilder('f')
            ->orderBy('f.title', 'ASC')
            ->getQuery();

            $pagination = $paginator->paginate(
                $query,
                $request->query->getInt('page', 1),
                9
            );
        
        return $this->render('film/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    #[Route('/films/{id}', name: 'app_film_show', requirements: ['id' => '\d+'])]
    public function show(Film $film): Response
    {
        return $this->render('film/show.html.twig', [
            'film' => $film,
        ]);
    }
}