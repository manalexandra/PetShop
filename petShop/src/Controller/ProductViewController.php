<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderProduct;
use App\Entity\Product;
use App\Entity\Rating;
use App\Entity\User;
use App\Form\RatingForm;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductViewController extends AbstractController
{
    /**
     * @Route("/product/view/{id}", name="app_product_view")
     */
    public function productView(Product $product, ManagerRegistry $doctrine): Response
    {
        $ratingForm = null;
        if ($this->getUser()) {
            $ratingForm = $this->createForm(RatingForm::class, new Rating($this->getUser(), $product));
        }

        return $this->render('product_view/productDetails.html.twig', [
            'product' => $product,
            'ratingForm' => $ratingForm?->createView(),
        ]);
    }

    /**
     * @Route("/product/{id}/ratings", name="app_product_ratings")
     */
    public function productRatings(Product $product, Request $request, EntityManagerInterface $entityManager)
    {
        $ratingForm = null;

        if ($this->getUser()) {
            $ratingForm = $this->createForm(RatingForm::class, new Rating($this->getUser(), $product));
        }

        if ($request->isMethod('POST')) {

            $this->denyAccessUnlessGranted('ROLE_USER');

            $ratingForm->handleRequest($request);

            if ($ratingForm->isSubmitted() && $ratingForm->isValid()) {
                $entityManager->persist($ratingForm->getData());
                $entityManager->flush();
                $this->addFlash('success', 'Thanks for your review!');
                return $this->redirectToRoute('app_product_view', [
                    'id' => $product->getId(),
                ]);
            }
            return $this->renderForm('product_view/productDetails.html.twig', [
                'product' => $product,
                'ratingForm' => $ratingForm,
            ]);
        }

        return $this->redirectToRoute("app_product_view", [
            'id' => $product->getId(),
        ]);
    }
}
