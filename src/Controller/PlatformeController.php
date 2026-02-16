<?php

namespace App\Controller;

use App\Repository\PlatformeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PlateformeController extends AbstractController
{
    #[Route('/platformes', name: 'app_platformes')]
    public function index(PlatformeRepository $plateformeRepository): Response
    {
        $platformes = $plateformeRepository->findAll();
        
        return $this->render('platforme/index.html.twig', [
            'platformes' => $platformes,
        ]);
    }
}