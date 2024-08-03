<?php

declare(strict_types=1);

namespace App\Domain\Service\ProductFRestaurant;

use App\Data\Repository\ProductFRestaurantRepository;
use App\Data\Repository\ProductRepository;
use App\Domain\Feature\ProductDocument\FRestaurantProducts\FRestaurantProducts;
use App\Domain\Feature\ProductDocument\FRestaurantProducts\FRestaurantProductsItem;

class ProductFRestaurantSeeder
{
    public function __construct(
        private readonly ProductFRestaurantRepository $repository,
        private readonly ProductRepository $productRepository,
    ) {
    }

    public function fillDbTableByProductListFile(string $filename): void
    {
        $productTable = FRestaurantProducts::fromFile($filename);
        $fRestaurantProducts = [];

        foreach ($productTable->getItems() as $item) {
            /** @var FRestaurantProductsItem $item */

            $code = $item->code;
            $name = $item->name;

            // if ($item->name === 'Soda dzeramā') {
            //     $name = " $name";
            // }

            // if ($item->name === 'Makaroni  Lazanja  un Kus kus') {
            //     $code = " $code";
            // }

            $fRestaurantProducts[] = $this->repository->createEntity($code, $name);
        }

        $this->repository->saveList($fRestaurantProducts);
        $this->repository->flush();
    }

    public function linkAllWithProducts(): void
    {
        $frestaurantProducts = $this->repository->findAll();
        $products = $this->productRepository->findAll();

        $debugNone = ['none'];
        $debugCodes = ['codes'];

        // frestaurant_code => frestaurant_name
        $productsWithDifferentNames = [
            "02-030"   => "Cāļu_broileru fileja ( savaiga)",
            "02-039"   => "Cūkgaļas krūt.  //  NAV UZTV!",
            "02-010"   => "Cūkgaļas krūt.ar kaulu  // NAV UZTV!",
            "04-0281"  => "Gurķi lauki",
            "07-019"   => "Iebiezināts piens",
            "01-0008"  => "Jogurts ar augļu piedevām",
            "01-0004_" => "Jogurts bezpiedevu",
            "01-0003"  => "Kefīrs 2% ",
            "11-008"   => "Kruasāns sviesta, graudu",
            "07-004_"  => "Krējums saldais \"Milac GOLD\"",
            // "01-0010"  => "Krēmsiers Baltais",
            "04-006"   => "Kāposti svaigie",
            "02-037"   => "Liellopa kotlešu gaļa",
            "11-012."  => "Maizīte ar karameļu pildījumu 60g",
            "05-041"   => "Makaroni pilngraudu (spirāles, radziņi)",
            "04-048"   => "Mandarīni",
            "07-012_"  => "Marinēt šampinjoni ROLNIK, 1.7 kg",
            "07-006"   => "Mērce worcesteshire",
            // "12-011"   => "Rozīnes",
            "05-006"   => "Rīsi paraboiled",
            "11-03"    => "Saldēta paprika strēmelītēs mix",
            "04-039"   => "Salāti Lollo Biondo",
            "04-036"   => "Salāti ledus (iceberg)",
            "08-007"   => "Sarkanās paprikas pulveris",
            "04-049"   => "Selerijas sakne",
            // "01-0013"  => "Svagais siers bez piedevām",
            "02-032"   => "Vistas filejas gabaliņi",
            "02-199"   => "Vistas kotlešu gaļa",
            "05-0156"  => "Četru graudu pārslas",
            "08-001"   => "Želatīns",
            "12-010"   => "Žāvētu augļu maisījums, rieksti, rozīnes",
        ];

        $strictTwins = [
            'Makaroni  Lazanja  un Kus kus' => $this->productRepository->findOneByHorizonName(
                'Makaroni  Lazanja, spageti  un Kus kus'
            ),
            'Rozīnes' => $this->productRepository->findOneByHorizonName(
                'Rozīnes'
            ),
            'Svagais siers bez piedevām' => $this->productRepository->findOneByHorizonName(
                'Krēmsiers BALTAIS  (klasiskais) bez piedēvam'
            ),
            'Cepamais pulveris,  SODA' => $this->productRepository->findOneByHorizonName(
                'Soda dzeramā'
            ),
            'Pētersīļi SALDĒTI' => $this->productRepository->findOneByHorizonName(
                'Pētersili svaigi'
            ),
            'Kāposti svaigie' => $this->productRepository->findOneByHorizonName(
                'Kāposti jaunie'
            ),
        ];

        foreach ($frestaurantProducts as $frestaurant) {
            if ($frestaurant->getLocalTwin() !== null) {
                continue;
            }

            $matchedProduct = $strictTwins[$frestaurant->getName()] ?? current(array_filter(
                $products,
                function ($product) use ($frestaurant) {
                    $hroizonCode = $product->getHorizonTwin()->getCode();
                    $hroizonSimpleName = self::simplifyName($product->getHorizonTwin()->getName());
                    $frestaurantCode = $frestaurant->getCode();
                    $frestaurantSimpleName = self::simplifyName($frestaurant->getName());

                    return $hroizonCode === $frestaurantCode || $hroizonSimpleName === $frestaurantSimpleName;
                }
            ));

            if (!$matchedProduct) {
                if (!isset($strictTwins[$frestaurant->getName()])) {
                    $debugNone[] = $frestaurant->getCode() . ' ----- ' . $frestaurant->getName();

                    continue;
                }

                $matchedProduct = $strictTwins[$frestaurant->getName()];
            }

            $frestaurantCode = $frestaurant->getCode();
            $frestaurantSimpleName = self::simplifyName($frestaurant->getName());
            $hroizonCode = $matchedProduct->getHorizonTwin()->getCode();
            $hroizonSimpleName = self::simplifyName($matchedProduct->getHorizonTwin()->getName());

            $areNamesEqual = $hroizonSimpleName === $frestaurantSimpleName;
            $areSpecialProducts = $frestaurantCode === $hroizonCode
                && isset($productsWithDifferentNames[$frestaurantCode])
                && $productsWithDifferentNames[$frestaurantCode] === $frestaurant->getName()
            ;
            $areSpecialSpecialProducts = isset(
                $strictTwins[$frestaurant->getName()]
            );
            $areCodesEqual = $hroizonCode === $frestaurantCode;

            if ($areNamesEqual || $areSpecialProducts || $areSpecialSpecialProducts) {
                $frestaurant->setLocalTwin($matchedProduct);
                $this->repository->save($frestaurant);
            } elseif ($areCodesEqual) {
                // // Write unprocessed results to debuging variables
                // $debugCodes[] = '---';
                // $debugCodes[] = '---';
                // // $codes[] = '"' . $frestaurant->getCode() . '"' . ' => ' . '"' . $frestaurant->getName() . '"';
                // $debugCodes[] = $frestaurant->getCode();
                // $debugCodes[] = $frestaurant->getName();
                // $debugCodes[] = $matchedProduct->getHorizonTwin()->getName();
            } else {
                throw new \LogicException();
            }
        }

        $this->repository->flush();

        // // Print unprocessed data
        // dd($debugNone, $debugCodes);
    }

    public function clear(): void
    {
        $this->repository->deleteAll();
        $this->repository->flush();
    }

    private static function simplifyName(string $name): string
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

        $name = mb_strtolower($name);
        $name = trim($name);

        foreach ($table as $invalid => $valid) {
            $name = str_replace($invalid, $valid, $name);
        }

        $name = preg_replace('/\(/', '', $name);
        $name = preg_replace('/\)/', '', $name);
        $name = preg_replace('/_/', ' ', $name);
        $name = preg_replace('/[ ]{1,}/', ' ', $name);
        $name = preg_replace('/ kg$/', '', $name);
        $name = preg_replace('/[^A-Za-z0-9-]+/', '-', $name);
        $name = trim($name);

        return $name;
    }
}
