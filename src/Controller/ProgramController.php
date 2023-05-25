<?php

namespace App\Controller;

use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use App\Form\ProgramType;
use App\Repository\ProgramRepository;
use Symfony\Component\HttpFoundation\Request;
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
    #[Route('/program/new', name: 'new')]
    public function new(Request $request, ProgramRepository $programRepository): Response
    {
        $program = new Program();

        // Create the form, linked with $category
        $form = $this->createForm(ProgramType::class, $program);
        $form->handleRequest($request);

        if ($form->isSubmitted())
        {
            $programRepository->save($program, true);

            return $this->redirectToRoute('category_index');
        }

        // Render the form

        return $this->render('program/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/program/{id}', name: 'program_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(Program $program): Response
    {
        return $this->render(
            'program/show.html.twig',
            [
                'program' => $program,
            ]
        );
    }

    #[Route('/program/{program}/season/{season}', name: 'program_season_show', requirements: ['program' => '\d+', 'season' => '\d+'], methods: ['GET'])]
    public function showSeason(Program $program, Season $season): Response
    {
        return $this->render(
            'season/show.html.twig',
            [
                'program' => $program,
                'season' => $season,
            ]
        );
    }


    #[Route('/program/{program}/season/{season}/episode/{episode}', name: 'program_episode_show')]
    public function showEpisode(Program $program, Season $season, Episode $episode): Response
    {
        return $this->render('episode/show.html.twig', [
            'program' => $program,
            'season' => $season,
            'episode' => $episode,
        ]);
    }
}
