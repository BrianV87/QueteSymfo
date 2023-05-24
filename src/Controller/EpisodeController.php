<?php

namespace App\Controller;

use App\Repository\EpisodeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EpisodeController extends AbstractController
{
    #[Route('/episode', name: 'episode_index')]
    public function index(EpisodeRepository $episodeRepository): Response
    {
        $episodes = $episodeRepository->findAll();

        return $this->render('episode/index.html.twig', [
            'episodes' => $episodes,
        ]);
    }

    #[Route('/episode/{id}', name: 'episode_show', requirements: ['id' => '\d+'])]
    public function show(int $id, EpisodeRepository $episodeRepository): Response
    {
        $episode = $episodeRepository->find($id);

        if (!$episode) {
            throw $this->createNotFoundException(
                'No episode found for id ' . $id
            );
        }

        return $this->render('episode/show.html.twig', [
            'episode' => $episode,
        ]);
    }
}
