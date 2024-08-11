<?php

namespace App\Data\Repository;

use App\Data\Entity\ProductHorizon;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProductHorizon>
 */
class ProductHorizonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductHorizon::class);
    }

    public function flush(): void
    {
        $this->getEntityManager()->flush();
    }

    /**
     * @param ProductHorizon[] $horizonProducts
     */
    public function saveList(array $horizonProducts): void
    {
        foreach ($horizonProducts as $horizonProduct) {
            $this->getEntityManager()->persist($horizonProduct);
        }
    }

    public function deleteAll(): void
    {
        $horizonProducts = $this->findAll();

        foreach ($horizonProducts as $product) {
            $this->getEntityManager()->remove($product);
        }
    }

    public function findOneByName(string $name): ProductHorizon
    {
        return $this->createQueryBuilder('h')
            // ->join('\App\Data\Entity\Product', 'p')
            ->andWhere('h.name = :val')
            ->setParameter('val', $name)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    //    /**
    //     * @return ProductHorizon[] Returns an array of ProductHorizon objects
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

    //    public function findOneBySomeField($value): ?ProductHorizon
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
