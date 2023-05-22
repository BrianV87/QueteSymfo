<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProgramController extends AbstractController
{
    #[Route('/program', name: 'app_program')]
    public function index(): Response
    {
        return $this->render('program/index.html.twig', [
            'controller_name' => 'ProgramController',
        ]);
    }

    #[Route('/program/{id}', methods: ['GET'], requirements: ['id' => '\d+'], name: 'app_program_show')]
    public function show(int $id): Response
    {
        return $this->render(
            'program/index.html.twig',
            [
                'controller_name' => 'ProgramController',
                'program_id' => $id
            ]
        );
    }
}
