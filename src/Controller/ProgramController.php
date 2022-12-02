<?php

namespace App\Controller;

use App\Entity\Program;
use App\Form\ProgramType;
use App\Repository\ProgramRepository;
use App\Repository\SeasonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/program', name: 'program_')]
class ProgramController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ProgramRepository $programRepository): Response
    {
        $programs = $programRepository->findAll();
        return $this->render('program/index.html.twig', [
            'programs' => $programs,
        ]);
    }

    #[Route('/{id<\d+>}', name: 'show', methods: ['GET'])]
    public function show(int $id, ProgramRepository $programRepository)
    {
        $program = $programRepository->findOneBy(['id' => $id]);
        $seasons = $program->getSeasons();

        if (!$program) {
            throw $this->createNotFoundException(
                'No program with id : ' . $id . ' found in program\'s table.'
            );
        }
        return $this->render('program/show.html.twig', [
            'program' => $program,
            'seasons' => $seasons
        ]);
    }

    #[Route('/{programId}/season/{seasonId}', name: 'program_season_show')]
    public function showSeason(int $programId, int $seasonId, ProgramRepository $programRepository, SeasonRepository $seasonRepository)
    {
        $program=$programRepository->findOneBy(['id'=>$programId]);
        $season=$seasonRepository->findOneBy(['id'=>$seasonId]);
        $episodes=$season->getEpisodes();
        return $this->render('program/season_show.html.twig', [
            'program'=>$program,
            'season'=>$season,
            'episodes'=>$episodes,
        ]);

    }

    #[Route('/program/new', name: 'new')]
    public function new(Request $request, ProgramRepository $categoryRepository) : Response
    {
        $category = new Program();
        $form = $this->createForm(ProgramType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $categoryRepository->save($category, true);
            return $this->redirectToRoute('program_index');
        }
        return $this->renderForm('program/new.html.twig', [
            'form' => $form,
        ]);
    }
}