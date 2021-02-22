<?php

namespace App\Controller;

use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use App\Form\ProgramType;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/new", name="new")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $program = new Program();
        $form = $this->createForm(ProgramType::class, $program);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($program);
            $entityManager->flush();
            return $this->redirectToRoute('program_index');
        }

        return $this->render('program/new.html.twig', [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}", methods={"GET"}, requirements={"id"="\d+"}, name="show")
     * @param Program $program
     * @return Response
     */
    public function show(Program $program): Response
    {
        return $this->render('program/show.html.twig', [
            'program' => $program,
            'seasons' => $program->getSeasons()
        ]);
    }

    /**
     * @Route("/{program}/season/{season}", name="season_show")
     * @param Program $program
     * @param Season $season
     * @return Response
     */
    public function showSeason(Program $program, Season $season): Response
    {
        return $this->render('program/season_show.html.twig', [
            'episodes' => $season->getEpisodes(),
            'program' => $program,
            'season' => $season
        ]);
    }

    /**
     * @Route("/{program}/season/{season}/episode/{episode}", name="episode_show")
     * @param Program $program
     * @param Season $season
     * @param Episode $episode
     * @return Response
     */
    public function showEpisode(Program $program, Season $season, Episode $episode): Response
    {
        return $this->render('program/episode_show.html.twig', [
            'program' => $program,
            'season' => $season,
            'episode' => $episode
        ]);
    }

    /*
     * @Route("/{program_id}/comment/{comment_id}", name="show_comment")
     * @ParamConverter("program", class="App\Entity\Program", options={"mapping": {"program_id": "id"}})
     * @ParamConverter("comment", class="App\Entity\Comment", options={"mapping": {"comment_id": "id}})
     public function showProgrammComment(Program $program, Comment $comment): Response
     {
         return $this->render('comment.html.twig', [
             'program' => $program,
             'comment' => $comment
         ]);
     }
     */
}
