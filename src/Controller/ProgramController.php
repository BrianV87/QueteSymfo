<?php

namespace App\Controller;

use App\Repository\ProgramRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProgramController extends AbstractController
{
    #[Route('/program/', name: 'program_index')]
    public function index(ProgramRepository $programRepository): Response
    {
        $programs = $programRepository->findAll();
        return $this->render('program/index.html.twig', [
            'programs' => $programs,
        ]);
    }

    #[Route('/program/{id}', name: 'program_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(int $id, ProgramRepository $programRepository): Response
    {
        $program = $programRepository->find($id);
        return $this->render(
            'program/show.html.twig',
            [
                'program' => $program,
            ]
        );
    }
}
