<?php

namespace App\Controller;

use App\Repository\CategorySubcategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage(CategorySubcategoryRepository $categorySubcategoryRepository): Response
    {
        $categorySubcategories = $categorySubcategoryRepository->findAll();

        return $this->render('homepage/homepage.html.twig',[
            'categorySubcategories' => $categorySubcategories,
        ]);
    }
}
