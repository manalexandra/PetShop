<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\ShoppingCart;
use App\Entity\ShoppingCartProduct;
use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShoppingCartController extends AbstractController
{
    /**
     * @Route("/shopping/cart", name="app_shopping_cart")
     */
    public function shoppingCart(ManagerRegistry $doctrine): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        if(!$user){
            return $this->redirectToRoute('app_login');
        }

        $shoppingCartRepository = $doctrine->getRepository(ShoppingCart::class);
        $shoppingCart = $shoppingCartRepository->findOneBy(['user' => $user]);

        $manager = $doctrine->getManager();

        if(!$shoppingCart){
            $shoppingCart = new ShoppingCart();
            $shoppingCart->setUser($user);
            $manager->persist($shoppingCart);
            $manager->flush();
        }

        $shoppingCartProductRepository = $doctrine->getRepository(ShoppingCartProduct::class);
        $shoppingCartProducts = $shoppingCartProductRepository->findBy([
            'shoppingCart' => $shoppingCart,
        ]);

        return $this->render('shoppingCart/shoppingCart.html.twig', [
            'shoppingCartProducts' => $shoppingCartProducts,
            'shoppingCart' => $shoppingCart,
        ]);
    }

    /**
     * @Route("/addToCart/{id}/quantity/{quantity}", name="app_addToCart", methods={"POST"})
     */
    public function addToCart(Product $product, $quantity, ManagerRegistry $doctrine): Response
    {
        if($quantity < 0){
            $this->addFlash('error', 'Please enter a valid amount of products!');
            return new Response('Please enter a valid amount of products!');
        }

        /** @var User $user */
        $user = $this->getUser();

        if(!$user){
            $this->addFlash('error', 'Please login before adding products to the shopping cart!');
            return new Response('Please login before adding products to shopping cart!');
        }

        $shoppingCartRepository = $doctrine->getRepository(ShoppingCart::class);
        $shoppingCart = $shoppingCartRepository->findOneBy(['user' => $user]);

        $manager = $doctrine->getManager();

        if(!$shoppingCart){
            $shoppingCart = new ShoppingCart();
            $shoppingCart->setUser($user);
            $manager->persist($shoppingCart);
        }

        $shoppingCartProductRepository = $doctrine->getRepository(ShoppingCartProduct::class);
        $shoppingCartProduct = $shoppingCartProductRepository->findOneBy([
            'shoppingCart' => $shoppingCart,
            'product' => $product,
        ]);

        $stock = $product->getQuantity();

        if(!$shoppingCartProduct){
            if($quantity > $stock){
                $this->addFlash('error', 'Insufficient stock!');
                return new Response('Error!');
            } else {
                $shoppingCartProduct = new ShoppingCartProduct();
                $shoppingCartProduct
                    ->setShoppingCart($shoppingCart)
                    ->setProduct($product)
                    ->setQuantity($quantity);
                $this->addFlash('success', 'Product added in the shopping cart!');
            }
        } else {
            $currentQuantity = $shoppingCartProduct->getQuantity();
            $newQuantity = $currentQuantity + $quantity;
            if($newQuantity > $stock){
                $this->addFlash('error', 'Insufficient stock!');
                return new Response('Error!');
            }
            $shoppingCartProduct->setQuantity($newQuantity);
            $this->addFlash('success', 'Product added in the shopping cart!');
        }
        $manager->persist($shoppingCartProduct);

        $manager->flush();

        return new Response('Added!');
    }

    /**
     * @Route("/remove/product/{id}", name="app_removeFromCart", methods={"DELETE"})
     */
    public function removeFromCart(Product $product, ManagerRegistry $doctrine): Response
    {
        $shoppingCartProductRepository = $doctrine->getRepository(ShoppingCartProduct::class);
        $shoppingCartProduct = $shoppingCartProductRepository->findOneBy([
            'product' => $product,
        ]);
        $manager = $doctrine->getManager();

        $manager->remove($shoppingCartProduct);
        $this->addFlash('success', 'Product deleted successfully!');
        $manager->flush();

        return $this->redirectToRoute('app_shopping_cart');
    }

    /**
     * @Route("/updateProduct/{id}/quantity/{quantity}", name="app_updateQuantityFromCart", methods={"POST"})
     */
     public function updateQuantityFromCart(Product $product, $quantity, ManagerRegistry $doctrine) : Response
     {
         $shoppingCartProductRepository = $doctrine->getRepository(ShoppingCartProduct::class);
         $shoppingCartProduct = $shoppingCartProductRepository->findOneBy([
             'product' => $product,
         ]);

         $manager = $doctrine->getManager();

         $stock = $product->getQuantity();

         if($quantity > $stock){
             $this->addFlash('error', 'Insufficient stock!');
             return $this->redirectToRoute('app_shopping_cart');
         }
         if($quantity < 0){
             $this->addFlash('error', 'Please enter a valid amount of products!');
             return $this->redirectToRoute('app_shopping_cart');
         }
         $shoppingCartProduct->setQuantity($quantity);
         $this->addFlash('success', 'Product quantity updated!');

         $manager->persist($shoppingCartProduct);

         $manager->flush();

         return $this->redirectToRoute('app_shopping_cart');
     }
}
