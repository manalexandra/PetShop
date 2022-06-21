<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductsController extends AbstractController
{
    /**
     * @Route("/products/{category}", name="app_products")
     */
    public function productsListViewByCategory($category, ProductRepository $productRepository): Response
    {
        return $this->render('products/index.html.twig', [
            'products' => $productRepository->findProductByCategory($category),
        ]);
    }

    /**
     * @Route("/products/{category}/{subcategory}", name="app_products_subcategory")
     */
    public function productsListViewBySubcategory($category, $subcategory, ProductRepository $productRepository): Response
    {
        return $this->render('products/index.html.twig', [
            'products' => $productRepository->findProductBySubcategory($category, $subcategory),
        ]);
    }
}
