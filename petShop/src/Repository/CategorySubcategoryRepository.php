<?php

namespace App\Repository;

use App\Entity\CategorySubcategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CategorySubcategory>
 *
 * @method CategorySubcategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategorySubcategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategorySubcategory[]    findAll()
 * @method CategorySubcategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategorySubcategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategorySubcategory::class);
    }

    public function add(CategorySubcategory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CategorySubcategory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
