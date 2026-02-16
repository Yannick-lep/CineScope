<?php

namespace App\Controller;

use App\Entity\Film;
use App\Repository\FilmRepository;
use App\Repository\PlatformeRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FilmController extends AbstractController
{
    #[Route('/films', name: 'app_films')]
    public function index(
        FilmRepository $filmRepository, 
        PlatformeRepository $plateformeRepository,
        PaginatorInterface $paginator, 
        Request $request
    ): Response
    {
        $search = $request->query->get('search', '');
        $year = $request->query->get('year', '');
        $platformeId = $request->query->get('platforme', '');
        
        $queryBuilder = $filmRepository->createQueryBuilder('f')
            ->leftJoin('f.platformes', 'p')
            ->addSelect('p')
            ->orderBy('f.title', 'ASC');
        
        // Recherche par titre
        if ($search) {
            $queryBuilder
                ->andWhere('f.title LIKE :search')
                ->setParameter('search', '%' . $search . '%');
        }
        
        // Filtre par année
        if ($year) {
            $queryBuilder
                ->andWhere('f.releaseYear = :year')
                ->setParameter('year', $year);
        }
        
        // Filtre par plateforme
        if ($platformeId) {
            $queryBuilder
                ->andWhere('p.id = :platformeId')
                ->setParameter('platformeId', $platformeId);
        }
        
        $query = $queryBuilder->getQuery();

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            9
        );
        
        // Récupérer les années disponibles
        $years = $filmRepository->createQueryBuilder('f')
            ->select('DISTINCT f.releaseYear')
            ->orderBy('f.releaseYear', 'DESC')
            ->getQuery()
            ->getResult();

        return $this->render('film/index.html.twig', [
            'pagination' => $pagination,
            'search' => $search,
            'selectedYear' => $year,
            'selectedPlatforme' => $platformeId,
            'years' => array_column($years, 'releaseYear'),
            'platformes' => $plateformeRepository->findAll(),
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