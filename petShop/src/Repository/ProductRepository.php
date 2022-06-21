<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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

    public function findProductByCategory($category) : array
    {
        return $this->createQueryBuilder('p')
            ->innerJoin('p.categorySubcategory', 'cs')
            ->innerJoin('cs.category', 'c')
            ->where('c.animalType = :animalType')
            ->setParameter('animalType', $category)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findProductBySubcategory($category, $subcategory) : array
    {
        return $this->createQueryBuilder('p')
            ->innerJoin('p.categorySubcategory', 'cs')
            ->innerJoin('cs.category', 'c')
            ->innerJoin('cs.subcategory', 's')
            ->where('c.animalType = :animalType and s.name = :name')
            ->setParameter('animalType', $category)
            ->setParameter('name', $subcategory)
            ->getQuery()
            ->getResult()
            ;
    }

//    /**
//     * @return Product[] Returns an array of Product objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Product
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value) 
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
