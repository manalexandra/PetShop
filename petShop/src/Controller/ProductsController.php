<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductsController extends AbstractController
{
    /**
     * @Route("/products/{category}/{subcategory}", name="app_products", defaults={"subcategory" = null, "category" = null})
     */
    public function productsListView($category, $subcategory, ProductRepository $productRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $category = $category ?? '';
        $subcategory = $subcategory ?? '';
        $sortedOptionText = $request->query->get('sortedOptionText');
        $sortBy = $request->query->get('sortBy', 'id');
        $direction = $request->query->get('direction', 'ASC');
        $minPrice = $request->query->get('minPrice', 0);
        $maxPrice = $request->query->get('maxPrice', 999999);
        $productName = $request->query->get('productName', '');
        $page = $request->query->getInt('page', 1);

        $currentUrl = $request->getRequestUri();

        $queryBuilder = $productRepository->findProductBySubcategory($category, $subcategory, $minPrice, $maxPrice, $sortBy, $direction, $productName);

        $pagination = $paginator->paginate(
            $queryBuilder,
            $page,
            6
        );

        return $this->render('products/index.html.twig', [
            'pagination' => $pagination,
            'selectedOptionText' => $sortedOptionText,
            'currentUrl' => $currentUrl,
            'minPrice' => $minPrice,
            'maxPrice' => $maxPrice,
            'productName' => $productName,
        ]);
    }
}
