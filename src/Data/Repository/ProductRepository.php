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
        private ProductFRestaurantRepository $fRestaurantRepository,
        private ProductHorizonRepository $horizonRepository,
    ) {
        parent::__construct($registry, Product::class);
    }

    public function flush(): void
    {
        $this->getEntityManager()->flush();
    }

    public function createEntity(string $name, string $slug = null, string $orderName = null): Product
    {
        if ($slug === null) {
            // $slug = trim($name);
            // $slug = strtolower($generatedSlug);
            $slug = self::makeSlug($name);
        }

        if ($orderName === null) {
            $orderName = $name;
        }

        return (new Product())
            ->setName($name)
            ->setSlug($slug)
            ->setOrderName($orderName)
        ;
    }

    /**
     * @param Product[] $products
     */
    public function saveList(array $products): void
    {
        foreach ($products as $product) {
            $this->getEntityManager()->persist($product);
        }
    }

    public function deleteAll(): void
    {
        $products = $this->findAll();

        foreach ($products as $product) {
            $this->getEntityManager()->remove($product);
        }
    }

    public function findOneByName(string $name): Product
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.name = :val')
            ->setParameter('val', $name)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findOneByHorizonName(string $name): Product
    {
        return $this->horizonRepository->findOneByName($name)->getLocalTwin();
    }

    public function findOneByHorizonCode(string $code): Product
    {
        return $this->horizonRepository->findOneByCode($code)->getLocalTwin();
    }

    /**
     * @param string[] $fRestaurantCodes
     *
     * @return Product[]
     */
    public function findListByFRestaurantCodes(array $codes): array
    {
        $fRestaurantProducts = $this->fRestaurantRepository->findListByCodes($codes);

        $productList = [];

        foreach ($fRestaurantProducts as $fRestaurantProduct) {
            $productList[] = $fRestaurantProduct->getLocalTwin();
        }

        return $productList;
    }

    private static function makeSlug(string $string): string
    {
        // TODO: Move this method somewhere

        $table = [
            'ā' => 'a',
            'ē' => 'e',
            'ī' => 'i',
            'ū' => 'u',
            'č' => 'c',
            'ģ' => 'g',
            'ķ' => 'k',
            'ļ' => 'l',
            'ņ' => 'n',
            'š' => 's',
            'ž' => 'z',
        ];

        $slug = $string;
        $slug = mb_strtolower($slug);
        $slug = trim($slug);

        foreach ($table as $invalid => $valid) {
            $slug = str_replace($invalid, $valid, $slug);
        }

        $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $slug);

        return $slug;
    }
}
