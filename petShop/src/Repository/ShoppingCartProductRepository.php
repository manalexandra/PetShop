<?php

namespace App\Repository;

use App\Entity\ShoppingCartProduct;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ShoppingCartProduct>
 *
 * @method ShoppingCartProduct|null find($id, $lockMode = null, $lockVersion = null)
 * @method ShoppingCartProduct|null findOneBy(array $criteria, array $orderBy = null)
 * @method ShoppingCartProduct[]    findAll()
 * @method ShoppingCartProduct[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShoppingCartProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShoppingCartProduct::class);
    }

    public function add(ShoppingCartProduct $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ShoppingCartProduct $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
