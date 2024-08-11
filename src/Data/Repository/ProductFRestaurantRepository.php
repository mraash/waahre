<?php

namespace App\Data\Repository;

use App\Data\Entity\ProductFRestaurant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProductFRestaurant>
 */
class ProductFRestaurantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductFRestaurant::class);
    }

    public function flush(): void
    {
        $this->getEntityManager()->flush();
    }

    public function save(ProductFRestaurant $frestarantProduct): void
    {
        $this->getEntityManager()->persist($frestarantProduct);
    }

    /**
     * @param ProductFRestaurant[] $fRestaurantProducts
     */
    public function saveList(array $fRestaurantProducts): void
    {
        foreach ($fRestaurantProducts as $fRestaurantProduct) {
            $this->save($fRestaurantProduct);
        }
    }

    public function deleteAll(): void
    {
        $products = $this->findAll();

        foreach ($products as $product) {
            $this->getEntityManager()->remove($product);
        }
    }

    public function findOneByName(string $name): ProductFRestaurant
    {
        return $this->findOneBy(['name' => $name]);
    }

    public function findAll(): array
    {
        return $this->createQueryBuilder('f')
            ->orderBy('f.name', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @param string[] $codes
     *
     * @return ProductFRestaurant[]
     */
    public function findListByCodes(array $codes): array
    {
        // TODO: read
        $products = $this->findBy(['code' => $codes]);

        // TODO: Process exception correctly
        if (in_array(null, $products)) {
            throw new \DomainException("Unknown 4Restaurant code");
        }

        return $products;

        // return $this->createQueryBuilder('p')
        //     ->andWhere('p.code = :val')
        //     ->setParameter('val', $codes)
        //     ->orderBy('p.name', 'ASC')
        //     ->getQuery()
        //     ->getResult()
        // ;
    }

    //    public function findOneBySomeField($value): ?ProductFRestaurant
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
