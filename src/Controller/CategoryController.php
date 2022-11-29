<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ProgramRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route('/category/', name: 'category_index')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();
        return $this->render('category/index.html.twig', ['categories' => $categories]);
    }

    #[Route('/category/show/{category}', name: 'category_show')]
    public function show(string $category, CategoryRepository $categoryRepository, ProgramRepository $programRepository): Response
    {
        $categoryName = $categoryRepository->findOneBy(['name' => $category]);
        if (!$categoryName) {
            throw $this->createNotFoundException(
                'No category found in category\'s table.'
            );
        }
        $programs = $programRepository->findBy(['category'=>$categoryName->getId()], ['id'=> 'DESC'], 3);
        return $this->render('category/show.html.twig', [
            'programs' => $programs,
            'category' => $categoryName
        ]);
    }
}