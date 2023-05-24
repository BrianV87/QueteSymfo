<?php

namespace App\Controller;

use App\Repository\SeasonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SeasonController extends AbstractController
{
    #[Route('/season', name: 'season_index')]
    public function index(SeasonRepository $seasonRepository): Response
    {
        $seasons = $seasonRepository->findAll();

        return $this->render('season/index.html.twig', [
            'seasons' => $seasons,
        ]);
    }

    #[Route('/season/{id}', name: 'season_show', requirements: ['id' => '\d+'])]
    public function show(int $id, SeasonRepository $seasonRepository): Response
    {
        $season = $seasonRepository->find($id);

        if (!$season) {
            throw $this->createNotFoundException(
                'No season found for id ' . $id
            );
        }

        return $this->render('season/show.html.twig', [
            'season' => $season,
        ]);
    }
}
