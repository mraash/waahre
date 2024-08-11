<?php

namespace App\Data\Repository;

use App\Base\Data\AbstractRepository;
use App\Data\Entity\ProductHorizon;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends AbstractRepository<ProductHorizon>
 */
class ProductHorizonRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductHorizon::class);
    }

    public function findOneByName(string $name): ProductHorizon
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.name = :val')
            ->setParameter('val', $name)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
