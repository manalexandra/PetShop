<?php

namespace App\Controller\Admin;

use App\Entity\Brand;
use App\Entity\Category;
use App\Entity\CategorySubcategory;
use App\Entity\DeliveryAddress;
use App\Entity\Order;
use App\Entity\OrderProduct;
use App\Entity\Product;
use App\Entity\ShoppingCart;
use App\Entity\Subcategory;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
         $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
         return $this->redirect($adminUrlGenerator->setController(ProductCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('PetShop Admin');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToCrud('Products', 'fa-brands fa-product-hunt', Product::class);
        yield MenuItem::linkToCrud('Users', 'fa-solid fa-user', User::class);
        yield MenuItem::linkToCrud('Delivery Addresses', 'fa-solid fa-location-dot', DeliveryAddress::class);
        yield MenuItem::linkToCrud('Brands', 'fa-solid fa-list-ul', Brand::class);
        yield MenuItem::linkToCrud('Categories', 'fa-solid fa-list-ul', Category::class);
        yield MenuItem::linkToCrud('Subcategories', 'fa-solid fa-list-ul', Subcategory::class);
        yield MenuItem::linkToCrud('Categories-Subcategories', 'fa-solid fa-list-ul', CategorySubcategory::class);
        yield MenuItem::linkToCrud('Orders', 'fa-solid fa-list-ul', Order::class);
        yield MenuItem::linkToCrud('Order-Products', 'fa-solid fa-list-ul', OrderProduct::class);
    }
}
