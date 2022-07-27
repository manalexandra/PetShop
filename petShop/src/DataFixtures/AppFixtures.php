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
            'phoneNumber' => '0725146612',
        ],
        [
            'firstName' => 'Maria',
            'lastName' => 'Popescu',
            'email' => 'mariapopescu@email.com',
            'password' => 'maria',
            'phoneNumber' => '0712547712',
        ],
        [
            'firstName' => 'Alex',
            'lastName' => 'Muresan',
            'email' => 'alexmuresan@email.com',
            'password' => 'alex',
            'phoneNumber' => '0714255602',
        ],
        [
            'firstName' => 'Mihai',
            'lastName' => 'Lucaciu',
            'email' => 'mihailucaciu@email.com',
            'password' => 'mihai',
            'phoneNumber' => '0725114425',
        ],
        [
            'firstName' => 'Andreea',
            'lastName' => 'Stan',
            'email' => 'andreeastan@email.com',
            'password' => 'andreea',
            'phoneNumber' => '0714425322'
        ],
    ];

    private const DOG_PICTURES = [
        'dog.jpg',
        'dog1.jpg',
        'dog2.jpg',
        'dog3.jpg',
        'dog4.jpg',
        'dogLeash.jpg',
        'dogLeash1.jpg',
        'dogLeash2.jpg',
        'dogLeash3.jpg',
        'dogLeash4.jpg',
        'dogClothes.jpg',
        'dogClothes1.jpg',
        'dogClothes2.jpg',
        'dogClothes3.jpg',
        'dogClothes4.jpg',
        'dogCage.jpg',
        'dogCage1.jpg',
        'dogCage2.jpg',
        'dogCage3.jpg',
        'dogCage4.jpg',
        'dogToy.jpg',
        'dogToy1.jpg',
        'dogToy2.jpg',
        'dogToy3.jpg',
        'dogToy4.jpg',
    ];

    private const CAT_PICTURES = [
        'cat.jpg',
        'cat1.jpg',
        'cat2.jpg',
        'cat3.jpg',
        'cat4.jpg',
        'catLeash.jpg',
        'catLeash1.jpg',
        'catLeash2.jpg',
        'catLeash3.jpg',
        'catLeash4.jpg',
        'catClothes.jpg',
        'catClothes1.jpg',
        'catClothes2.jpg',
        'catClothes3.jpg',
        'catClothes4.jpg',
        'catCage.jpg',
        'catCage1.jpg',
        'catCage2.jpg',
        'catCage3.jpg',
        'catCage4.jpg',
        'catToy.jpg',
        'catToy1.jpg',
        'catToy2.jpg',
        'catToy3.jpg',
        'catToy4.jpg',
    ];

    private const BIRD_PICTURES = [
        'bird.jpg',
        'bird1.jpg',
        'bird2.jpg',
        'bird3.jpg',
        'bird4.jpg',
        'birdCage.jpg',
        'birdCage1.jpg',
        'birdCage2.jpg',
        'birdCage3.jpg',
        'birdCage4.jpg',
        'birdToy.jpg',
        'birdToy1.jpg',
        'birdToy2.jpg',
        'birdToy3.jpg',
        'birdToy4.jpg',
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
        $user = new User();
        $user
            ->setFirstName('admin')
            ->setLastName('admin')
            ->setEmail('admin@email.com')
            ->setPassword($this->passwordHasher->hashPassword($user, 'admin1'))
            ->setPhoneNumber('0742589632')
            ->setRoles(['ROLE_ADMIN']);
        $manager->persist($user);
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
                ->setDescription(substr(self::DESCRIPTION, rand(0,100), rand(-100,-1)))
                ->setName($this->getReference($randomCategorySubcategory)->getSubcategory()->getName().' '.$i)
                ->setCategorySubcategory($this->getReference($randomCategorySubcategory));

            switch ($randomCategorySubcategory){
                case 0:
                    $product->setImage(self::DOG_PICTURES[rand(0,4)]);
                    break;
                case 1:
                    $product->setImage(self::DOG_PICTURES[rand(5,9)]);
                    break;
                case 2:
                    $product->setImage(self::DOG_PICTURES[rand(10, 14)]);
                    break;
                case 3:
                    $product->setImage(self::DOG_PICTURES[rand(15, 19)]);
                    break;
                case 4:
                    $product->setImage(self::DOG_PICTURES[rand(20, 24)]);
                    break;
                case 5:
                    $product->setImage(self::CAT_PICTURES[rand(0,4)]);
                    break;
                case 6:
                    $product->setImage(self::CAT_PICTURES[rand(5,9)]);
                    break;
                case 7:
                    $product->setImage(self::CAT_PICTURES[rand(10, 14)]);
                    break;
                case 8:
                    $product->setImage(self::CAT_PICTURES[rand(15, 19)]);
                    break;
                case 9:
                    $product->setImage(self::CAT_PICTURES[rand(20, 24)]);
                    break;
                case 10:
                    $product->setImage(self::BIRD_PICTURES[rand(0,4)]);
                    break;
                case 11:
                    $product->setImage(self::BIRD_PICTURES[rand(5,9)]);
                    break;
                case 12:
                    $product->setImage(self::BIRD_PICTURES[rand(10, 14)]);
                    break;
            }

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
