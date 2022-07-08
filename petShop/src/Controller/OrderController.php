<?php

namespace App\Controller;

use App\Entity\DeliveryAddress;
use App\Entity\Order;
use App\Entity\OrderProduct;
use App\Entity\ShoppingCart;
use App\Entity\ShoppingCartProduct;
use App\Entity\User;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    /**
     * @Route("/order", name="app_place_order", methods={"POST"})
     */
    public function order(ManagerRegistry $doctrine)
    {
        $manager = $doctrine->getManager();

        /** @var User $user */
        $user = $this->getUser();

        $saveAddress = ($_POST['saveAddress'] == 'true');

        if (!$saveAddress) {
            $country = $_POST['country'];
            $county = $_POST['county'];
            $city = $_POST['city'];
            $street = $_POST['street'];
            $number = $_POST['number'];
            $postalCode = $_POST['postalCode'];

            $deliveryAddress = new DeliveryAddress();
            $deliveryAddress
                ->setCountry($country)
                ->setCounty($county)
                ->setCity($city)
                ->setStreet($street)
                ->setNumber($number)
                ->setPostalCode($postalCode);
            $manager->persist($deliveryAddress);
        } else {
            $deliveryAddress = $user->getDeliveryAddress();
        }

        $shoppingCartRepository = $doctrine->getRepository(ShoppingCart::class);
        $shoppingCart = $shoppingCartRepository->findOneBy([
            'user' => $user
        ]);
        $totalPrice = $shoppingCart->getFinalPrice();
        $status = 'Pending';
        $createdAt = new DateTime();
        $orderNumber = rand(1000000000, 9999999999);

        $order = new Order();
        $order
            ->setUser($user)
            ->setDeliveryAddress($deliveryAddress)
            ->setTotalPrice($totalPrice)
            ->setStatus($status)
            ->setCreatedAt($createdAt)
            ->setOrderNumber($orderNumber);
        $manager->persist($order);

        $shoppingCartProductRepository = $doctrine->getRepository(ShoppingCartProduct::class);
        $shoppingCartProducts = $shoppingCartProductRepository->findBy([
            'shoppingCart' => $shoppingCart,
        ]);
        foreach ($shoppingCartProducts as $shoppingCartProduct) {
            $product = $shoppingCartProduct->getProduct();
            $shoppingCartProductQuantity = $shoppingCartProduct->getQuantity();
            $productStockQuantity = $product->getQuantity();
            $productStockQuantity -= $shoppingCartProductQuantity;

            if ($productStockQuantity < 0) {
                $this->addFlash('error', 'Some products are not in stock anymore and they have been removed from your cart!');
                $manager->remove($shoppingCartProduct);

                return $this->redirectToRoute('app_homepage');
            }
            $product->setQuantity($productStockQuantity);

            if($productStockQuantity == 0) {
                $product->setInStock(0);
            }

            $orderProduct = new OrderProduct();
            $orderProduct
                ->setOrder($order)
                ->setProduct($product)
                ->setQuantity($shoppingCartProductQuantity);
            $manager->persist($orderProduct);
            $manager->remove($shoppingCartProduct);
        }

        $manager->flush();

        $this->addFlash('success', 'Order placed successfully!');

        return $this->redirectToRoute('app_homepage');
    }

    /**
     * @Route("/ordersList", name="app_orders_list")
     */
    public function ordersList(ManagerRegistry $doctrine) : Response
    {
        /** @var User $user */
        $user = $this->getUser();

        if(!$user){
            return $this->redirectToRoute('app_login');
        }

        $orderRepository = $doctrine->getRepository(Order::class);
        $order = $orderRepository->findBy([
            'user' => $user
        ]);

        return $this->render('order/order.html.twig', [
            'ordersList' => $order,
            'user' => $user,
        ]);
    }
}
