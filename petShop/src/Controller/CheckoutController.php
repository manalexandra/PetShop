<?php

namespace App\Controller;

use App\Entity\DeliveryAddress;
use App\Entity\ShoppingCart;
use App\Entity\ShoppingCartProduct;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CheckoutController extends AbstractController
{
    /**
     * @Route("/checkout", name="app_checkout")
     */
    public function checkout(ManagerRegistry $doctrine): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        if(!$user){
            return $this->redirectToRoute('app_login');
        }

        $shoppingCartRepository = $doctrine->getRepository(ShoppingCart::class);
        $shoppingCart = $shoppingCartRepository->findOneBy([
            'user' => $user
        ]);

        $shoppingCartProductRepository = $doctrine->getRepository(ShoppingCartProduct::class);
        $shoppingCartProducts = $shoppingCartProductRepository->findBy([
            'shoppingCart' => $shoppingCart,
        ]);

        if(count($shoppingCartProducts) == 0){
            return $this->redirectToRoute('app_homepage');
        }

        return $this->render('checkout/checkout.html.twig', [
            'finalProductsList' => $shoppingCartProducts,
            'shoppingCart' => $shoppingCart,
            'user' => $user,
        ]);
    }

    /**
     * @Route("/validate/address", name="app_validate_address", methods={"POST"})
     */
    public function validateAddress()
    {
        $status = Response::HTTP_OK;

        $messages = [
            'country' => '',
            'county' => '',
            'city' => '',
            'street' => '',
            'number' => '',
            'postalCode' => '',
        ];
        if(!preg_match('/^[a-zA-Z]+[- ]?[a-zA-Z]+$/', $_POST['country'])){
            $messages['country'] = '*Please enter a valid country!';
            $status = Response::HTTP_BAD_REQUEST;
        }
        if(!preg_match('/^[a-zA-Z]+[- ]?[a-zA-Z]+$/', $_POST['county'])){
            $messages['county'] = '*Please enter a valid county!';
            $status = Response::HTTP_BAD_REQUEST;
        }
        if(!preg_match('/^[a-zA-Z]+[- ]?[a-zA-Z]+$/', $_POST['city'])){
            $messages['city'] = '*Please enter a valid city!';
            $status = Response::HTTP_BAD_REQUEST;
        }
        if(!preg_match('/^[a-zA-Z]+[- ]?[a-zA-Z]+$/', $_POST['street'])){
            $messages['street'] = '*Please enter a valid street!';
            $status = Response::HTTP_BAD_REQUEST;
        }
        if(!preg_match('/^\d+$/', $_POST['number'])){
            $messages['number'] = '*Please enter a valid number!';
            $status = Response::HTTP_BAD_REQUEST;
        }
        if(!preg_match('/^\d{6}+$/', $_POST['postalCode'])){
            $messages['postalCode'] = '*Please enter a valid postal code!';
            $status = Response::HTTP_BAD_REQUEST;
        }
        return new JsonResponse([
            'messages' => $messages,
            'status' => $status,
        ]);
    }

    /**
     * @Route("/saveAddress", name="app_save_address", methods={"POST"})
     */
    public function saveAddress(ManagerRegistry $doctrine): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        if(!$user){
            return $this->redirectToRoute('app_login');
        }

        $deliveryAddress = $user->getDeliveryAddress();

        $manager = $doctrine->getManager();

        $country = $_POST['country'];
        $county = $_POST['county'];
        $city = $_POST['city'];
        $street = $_POST['street'];
        $number = $_POST['number'];
        $postalCode = $_POST['postalCode'];

        if(!$deliveryAddress){
            $deliveryAddress = new DeliveryAddress();
            $deliveryAddress
                ->setCountry($country)
                ->setCounty($county)
                ->setCity($city)
                ->setStreet($street)
                ->setNumber($number)
                ->setPostalCode($postalCode);
            $deliveryAddress->addUser($user);
        } else {
            $deliveryAddress->setCountry($country);
            $deliveryAddress->setCounty($county);
            $deliveryAddress->setCity($city);
            $deliveryAddress->setStreet($street);
            $deliveryAddress->setNumber($number);
            $deliveryAddress->setPostalCode($postalCode);
        }
        $this->addFlash('success', 'Delivery Address saved successfully!');
        $manager->persist($deliveryAddress);
        $manager->flush();

        return $this->redirectToRoute('app_checkout');
    }
}
