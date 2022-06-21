<?php

namespace App\DataFixtures;

use App\Entity\Brand;
use App\Entity\Category;
use App\Entity\CategorySubcategory;
use App\Entity\DeliveryAddress;
use App\Entity\Product;
use App\Entity\Subcategory;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private const CATEGORIES = [
        'Dogs',
        'Cats',
        'Birds',
    ];

    private const SUBCATEGORIES = [
        'Food',
        'Leashes & Collars',
        'Clothes & Accessories',
        'Beds & Cages',
        'Toys',
    ];

    private const SUBCATEGORIES2 = [
        'Food',
        'Bird cages',
        'Accessories for bird cages',
    ];

    private const ALL_SUBCATEGORIES = [
        'Food',
        'Leashes & Collars',
        'Clothes & Accessories',
        'Beds & Cages',
        'Toys',
        'Bird cages',
        'Accessories for bird cages',
    ];

    private const BRAND = [
        'Royal Canin',
        'Gourmet',
        'Pro Plan',
        'Schesir',
        'Pro Accessories',
    ];

    private const DELIVERYADDRESS = [
        [
            'country' => 'Romania',
            'city' => 'Cluj-Napoca',
            'county' => 'Cluj',
            'street' => 'Lalelelor',
            'number' => 25,
            'postalCode' => 411255,
        ],
        [
            'country' => 'Romania',
            'city' => 'Bucuresti',
            'county' => 'Bucuresti',
            'street' => 'Victoriei',
            'number' => 88,
            'postalCode' => 489355,
        ],
        [
            'country' => 'Romania',
            'city' => 'Craiova',
            'county' => 'Dolj',
            'street' => 'Viilor',
            'number' => 12,
            'postalCode' => 484362,
        ],
        [
            'country' => 'Romania',
            'city' => 'Baia Mare',
            'county' => 'Maramures',
            'street' => 'Eroilor',
            'number' => 78,
            'postalCode' => 452188,
        ],
        [
            'country' => 'Romania',
            'city' => 'Targu Mures',
            'county' => 'Mures',
            'street' => 'Stejarului',
            'number' => 55,
            'postalCode' => 474771,
        ],
    ];

    private const USERS = [
        [
            'firstName' => 'Andrei',
            'lastName' => 'Pop',
            'email' => 'andreipop@email.com',
            'password' => 'andrei',
            'phoneNumber' => 0725146612,
        ],
        [
            'firstName' => 'Maria',
            'lastName' => 'Popescu',
            'email' => 'mariapopescu@email.com',
            'password' => 'maria',
            'phoneNumber' => 0712547712,
        ],
        [
            'firstName' => 'Alex',
            'lastName' => 'Muresan',
            'email' => 'alexmuresan@email.com',
            'password' => 'alex',
            'phoneNumber' => 0714255602,
        ],
        [
            'firstName' => 'Mihai',
            'lastName' => 'Lucaciu',
            'email' => 'mihailucaciu@email.com',
            'password' => 'mihai',
            'phoneNumber' => 0725114425,
        ],
        [
            'firstName' => 'Andreea',
            'lastName' => 'Stan',
            'email' => 'andreeastan@email.com',
            'password' => 'andreea',
            'phoneNumber' => 0714425322
        ],
    ];

    private const DESCRIPTION = "Lorem ipsum color sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.";

    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher){
        $this->passwordHasher = $passwordHasher;
    }

    public function loadCategories(ObjectManager $manager) {
        for($i = 0; $i < count(self::CATEGORIES); $i++) {
            $category = new Category();
            $category->setAnimalType(self::CATEGORIES[$i]);
            $this->addReference(self::CATEGORIES[$i], $category);
            $manager->persist($category);
        }
        $manager->flush();
    }

    public function loadSubcategories(ObjectManager $manager) {
        for($i = 0; $i < count(self::ALL_SUBCATEGORIES); $i++) {
            $subcategory = new Subcategory();
            $subcategory->setName(self::ALL_SUBCATEGORIES[$i]);
            $this->addReference(self::ALL_SUBCATEGORIES[$i], $subcategory);
            $manager->persist($subcategory);
        }
        $manager->flush();
    }

    public function createCategorySubcategory(ObjectManager $manager, $i, &$count, $subcategoryList){
        for ($j = 0; $j < count($subcategoryList); $j++) {
            $categorySubcategory = new CategorySubcategory();
            $categorySubcategory->setCategory($this->getReference(self::CATEGORIES[$i]));
            $categorySubcategory->setSubcategory($this->getReference($subcategoryList[$j]));
            $this->addReference($count++, $categorySubcategory);
            $manager->persist($categorySubcategory);
        }
    }

    public function loadCategorySubcategory(ObjectManager $manager) {
        $count = 0;
        for($i = 0; $i < count(self::CATEGORIES); $i++){
            if(self::CATEGORIES[$i] == 'Dogs' || self::CATEGORIES[$i] == 'Cats') {
                $this->createCategorySubcategory($manager, $i, $count, self::SUBCATEGORIES);
            } else {
                $this->createCategorySubcategory($manager, $i, $count, self::SUBCATEGORIES2);
            }
        }
        $manager->flush();
    }

    public function loadBrands(ObjectManager $manager) {
        for($i = 0; $i < count(self::BRAND); $i++) {
            $brand = new Brand();
            $brand->setName(self::BRAND[$i]);
            $this->addReference(self::BRAND[$i], $brand);
            $manager->persist($brand);
        }
        $manager->flush();
    }

    public function loadDeliveryAddresses(ObjectManager $manager) {
        for($i = 0; $i < count(self::DELIVERYADDRESS); $i++) {
            $deliveryAddress = new DeliveryAddress();
            $deliveryAddress
                ->setCountry(self::DELIVERYADDRESS[$i]['country'])
                ->setCity(self::DELIVERYADDRESS[$i]['city'])
                ->setCounty(self::DELIVERYADDRESS[$i]['county'])
                ->setStreet(self::DELIVERYADDRESS[$i]['street'])
                ->setNumber(self::DELIVERYADDRESS[$i]['number'])
                ->setPostalCode(self::DELIVERYADDRESS[$i]['postalCode']);
            $this->addReference(self::DELIVERYADDRESS[$i]['street'], $deliveryAddress);
            $manager->persist($deliveryAddress);
        }
        $manager->flush();
    }

    public function loadUsers(ObjectManager $manager) {
        for($i = 0; $i < count(self::USERS); $i++) {
            $user = new User();
            $user
                ->setFirstName(self::USERS[$i]['firstName'])
                ->setLastName(self::USERS[$i]['lastName'])
                ->setEmail(self::USERS[$i]['email'])
                ->setPassword($this->passwordHasher->hashPassword($user, self::USERS[$i]['password']))
                ->setPhoneNumber(self::USERS[$i]['phoneNumber'])
                ->setDeliveryAddress($this->getReference(self::DELIVERYADDRESS[$i]['street']));
            $manager->persist($user);
        }
        $manager->flush();
    }

    public function loadProducts(ObjectManager $manager) {
        for($i = 0; $i < 100; $i++) {
            $randomCategorySubcategory = rand(0,12);
            $product = new Product();
            $product
                ->setBrand($this->getReference(self::BRAND[rand(0,4)]))
                ->setPrice(rand(1000, 50000)/100)
                ->setInStock(rand(0,1) == 1)
                ->setQuantity($product->isInStock() ? rand(1,150) : 0)
                ->setImage('jpg '.$i)
                ->setDescription(substr(self::DESCRIPTION, rand(0,100), rand(-100,-1)))
                ->setName($this->getReference($randomCategorySubcategory)->getSubcategory()->getName().' '.$i)
                ->setCategorySubcategory($this->getReference($randomCategorySubcategory));
            $manager->persist($product);
        }
        $manager->flush();
    }

    public function load(ObjectManager $manager)
    {
        $this->loadCategories($manager);
        $this->loadSubcategories($manager);
        $this->loadCategorySubcategory($manager);
        $this->loadBrands($manager);
        $this->loadDeliveryAddresses($manager);
        $this->loadUsers($manager);
        $this->loadProducts($manager);
        $manager->flush();
    }
}
