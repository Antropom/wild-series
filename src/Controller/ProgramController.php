<?php

namespace App\Controller;

use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/programs", name="program_")
 */
class ProgramController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @return Response
     */
    public function index(): Response
    {
        $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findAll();
        return $this->render('program/index.html.twig', [
            'programs' => $programs
        ]);
    }

    /**
     * @Route("/{id}", methods={"GET"}, requirements={"id"="\d+"}, name="show")
     * @param int $id
     * @return Response
     */
    public function show(int $id): Response
    {
        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findOneBy(['id' => $id]);

        if (!$program) {
            throw $this->createNotFoundException(
                'No program with id : ' . $id . ' found in program\'s table.'
            );
        }

        return $this->render('program/show.html.twig', [
            'program' => $program,
            'seasons' => $program->getSeasons()
        ]);
    }

    /**
     * @Route("/{programId}/season/{seasonId}", name="season_show")
     * @param int $programId
     * @param int $seasonId
     * @return Response
     */
    public function showSeason(int $programId, int $seasonId): Response
    {
        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findOneBy(['id' => $programId]);

        if (!$program) {
            throw $this->createNotFoundException(
                'No program found for the id ' . $programId
            );
        }

        $season = $this->getDoctrine()
            ->getRepository(Season::class)
            ->findBy([
                'id' => $seasonId
            ]);

        if (!$season) {
            throw $this->createNotFoundException(
                'No season found for the id ' . $seasonId
            );
        }

        $episodes = $this->getDoctrine()
            ->getRepository(Episode::class)
            ->findBy(['season' => $season]);

        if (!$episodes) {
            throw $this->createNotFoundException(
                'No episode found for this show'
            );
        }

        return $this->render('program/season_show.html.twig', [
            'episodes' => $episodes,
            'program' => $program,
            'seasonNum' => $seasonId
        ]);
    }

}
