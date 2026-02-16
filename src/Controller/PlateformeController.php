<?php

namespace App\Controller;

use App\Repository\PlatformeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlateformeController extends AbstractController
{
    #[Route('/platformes', name: 'app_platformes')]
    public function index(PlatformeRepository $platformeRepository): Response
    {
        return $this->render('plateforme/index.html.twig', [
            'platformes' => $platformeRepository->findAll(),
        ]);
    }

    #[Route('/platformes/{id}', name: 'app_platforme_show')]
    public function show(int $id, PlatformeRepository $platformeRepository): Response
    {
        $platforme = $platformeRepository->find($id);

        if (!$platforme) {
            throw $this->createNotFoundException('Plateforme non trouvée');
        }

        return $this->render('plateforme/show.html.twig', [
            'platforme' => $platforme,
        ]);
    }
}
