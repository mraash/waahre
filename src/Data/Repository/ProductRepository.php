<?php

namespace App\Data\Repository;

use App\Data\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
        private ProductFRestaurantRepository $fRestaurantProductRepository,
    ) {
        parent::__construct($registry, Product::class);
    }

    /**
     * @param string[] $fRestaurantCodes
     *
     * @return Product[]
     */
    public function findListByFRestaurantCodes(array $codes): array
    {
        $fRestaurantProducts = $this->fRestaurantProductRepository->findListByCodes($codes);

        $productList = [];

        foreach ($fRestaurantProducts as $fRestaurantProduct) {
            $productList[] = $fRestaurantProduct->getLocalTwin();
        }

        return $productList;
    }

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
