<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="app_index")
     */

    public function index(): Response
    {
        return $this->render('/index.html.twig');
    }

    /**
     * @Route("my-profile", name="app_profile")
     */
    public function profile(): Response
    {
        return $this->render('/profile.html.twig');
    }
}
