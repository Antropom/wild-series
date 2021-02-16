<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
        return $this->render('program/index.html.twig', [
            'website' => 'Wild Series'
        ]);
    }

    /**
     * @Route("/{id}", methods={"GET"}, requirements={"id"="\d+"}, name="show")
     * @return Response
     */
    public function show(int $id): Response
    {
        return $this->render('program/show.html.twig', [
            'id' => $id
        ]);
    }

    /**
     * @Route("/{slug}",  name="not_found")
     * @return NotFoundHttpException
     */
    public function not_found(): NotFoundHttpException
    {
        throw $this->createNotFoundException('Serie not found');
    }
}
