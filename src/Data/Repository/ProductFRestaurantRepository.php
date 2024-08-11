<?php

namespace App\Data\Repository;

use App\Base\Data\AbstractRepository;
use App\Data\Entity\ProductFRestaurant;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends AbstractRepository<ProductFRestaurant>
 */
class ProductFRestaurantRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductFRestaurant::class);
    }

    public function findAll(): array
    {
        return $this->createQueryBuilder('f')
            ->orderBy('f.name', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findOneByName(string $name): ProductFRestaurant
    {
        return $this->findOneByCriteriaOrNull(['name' => $name]);
    }

    /**
     * @param string[] $codes
     *
     * @return ProductFRestaurant[]
     */
    public function findListByCodes(array $codes): array
    {
        // TODO: read
        $products = $this->findListByCriteria(['code' => $codes]);

        // TODO: Process exception correctly
        if (in_array(null, $products)) {
            throw new \DomainException("Unknown 4Restaurant code");
        }

        return $products;
    }
}
