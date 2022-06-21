<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductViewController extends AbstractController
{
    /**
     * @Route("/product/view/{id}", name="app_product_view")
     */
    public function productView(Product $product): Response
    {
        return $this->render('product_view/productDetails.html.twig', [
            'product' => $product,
        ]);
    }
}
