<?php

namespace App\Data\Repository;

use App\Base\Data\AbstractRepository;
use App\Data\Entity\Product;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends AbstractRepository<Product>
 */
class ProductRepository extends AbstractRepository
{
    public function __construct(
        ManagerRegistry $registry,
        private ProductFRestaurantRepository $fRestaurantRepository,
        private ProductHorizonRepository $horizonRepository,
    ) {
        parent::__construct($registry, Product::class);
    }

    public function findAll(): array
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.name', 'ASC')
            ->getQuery()
            ->getResult()
        ;
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

    public function findFirstByHorizonName(string $name): Product
    {
        // TODO: ->first() is not good
        return $this->horizonRepository->findOneByName($name)->getProductLinks()->first();
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
            // TODO: ->first() is not good
            $product = $fRestaurantProduct->getProductLinks()->first();

            // TODO: Process exception correctly
            if ($product === null) {
                throw new \DomainException("Unknown 4Restaurant code \"{$fRestaurantProduct->getCode()}\"");
            }

            $productList[] = $product;
        }

        return $productList;
    }

    public static function makeSlug(string $string): string
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

        foreach ($table as $invalid => $valid) {
            $slug = str_replace($invalid, $valid, $slug);
        }

        $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $slug);
        $slug = trim($slug, '-');

        return $slug;
    }
}
