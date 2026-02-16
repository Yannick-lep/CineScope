<?php

namespace App\Controller;

use App\Entity\Platforme;
use App\Form\PlateformeType;
use App\Repository\PlatformeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/platformes')]
#[IsGranted('ROLE_ADMIN')]
class AdminPlateformeController extends AbstractController
{
    #[Route(name: 'app_admin_plateforme_index', methods: ['GET'])]
    public function index(PlatformeRepository $platformeRepository): Response
    {
        return $this->render('admin_plateforme/index.html.twig', [
            'platformes' => $platformeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_plateforme_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $platforme = new Platforme();
        $form = $this->createForm(PlateformeType::class, $platforme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($platforme);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_plateforme_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_plateforme/new.html.twig', [
            'platforme' => $platforme,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_plateforme_show', methods: ['GET'])]
    public function show(Platforme $platforme): Response
    {
        return $this->render('admin_plateforme/show.html.twig', [
            'platforme' => $platforme,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_plateforme_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Platforme $platforme, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PlateformeType::class, $platforme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_plateforme_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_plateforme/edit.html.twig', [
            'platforme' => $platforme,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_plateforme_delete', methods: ['POST'])]
    public function delete(Request $request, Platforme $platforme, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$platforme->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($platforme);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_plateforme_index', [], Response::HTTP_SEE_OTHER);
    }
}
