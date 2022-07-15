<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function add(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findProductBySubcategory($category, $subcategory, $minPrice, $maxPrice, $property, $direction, $name) : QueryBuilder
    {
        return $this->createQueryBuilder('p')
            ->innerJoin('p.categorySubcategory', 'cs')
            ->innerJoin('cs.category', 'c')
            ->innerJoin('cs.subcategory', 's')
            ->where('c.animalType LIKE :animalType and s.name LIKE :name')
            ->andWhere('p.price >= :minPrice AND p.price <= :maxPrice')
            ->andWhere('p.name LIKE :productName')
            ->setParameter('productName', "%$name%")
            ->setParameter('minPrice', $minPrice)
            ->setParameter('maxPrice', $maxPrice)
            ->setParameter('animalType', "%$category%")
            ->setParameter('name', "%$subcategory%")
            ->orderBy("p.$property", $direction)
            ;
    }
}
