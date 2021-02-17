<?php


namespace App\Controller;


use App\Entity\Category;
use App\Entity\Program;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CategoryController
 * @Route("/categories", name="category_")
 * @package App\Controller
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        $categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();

        return $this->render('category/index.html.twig', [
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/{name}", methods={"GET"}, name="show")
     * @param $name
     * @return Response
     */
    public function show(string $name): Response
    {
        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findOneBy(['name' => $name]);

        if (!$category) {
            throw $this->createNotFoundException(
                'No category with the name : ' . $name . ' found in category\'s table.'
            );
        }

        $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findBy(
                ['category' => $category->getId()],
                ['id' => 'ASC'],
                3
            );

        if (!$programs) {
            throw $this->createNotFoundException(
                'No series in the ' . $category->getName() . ' category'
            );
        }

        return $this->render('category/show.html.twig', [
            'category' => $category,
            'programs' => $programs
        ]);
    }
}