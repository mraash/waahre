<?php

declare(strict_types=1);

namespace App\Http\Controller\Dev;

use App\Data\Repository\ProductFRestaurantRepository;
use App\Data\Repository\ProductHorizonRepository;
use App\Data\Repository\ProductRepository;
use App\Base\Http\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProductAssociationController extends AbstractController
{
    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly ProductHorizonRepository $productHorizonRepository,
        private readonly ProductFRestaurantRepository $productFRestaurantRepository,
        private string $projectDir,
    ) {
    }

    #[Route('/dev/product-associations', name: 'page.dev.productAssociations')]
    public function index(): Response
    {
        $allProducts = $this->productRepository->findAll();
        $allHorizon = $this->productHorizonRepository->findAll();
        $allFrestaurant = $this->productFRestaurantRepository->findAll();

        $productHasManyHorizon = [];
        $productHasManyFrestaurant = [];
        $productHasNoHorizon = [];
        $productHasNoFrestaurant = [];
        $productNormal = [];

        $horizonHasManyProducts = [];
        $horizonHasNoProducts = [];

        $frestaurantHasManyProducts = [];
        $frestaurantHasNoProducts = [];

        foreach ($allProducts as $product) {
            $horizonCount = $product->getHorizonLinks()->count();
            $frestaurantCount = $product->getFrestaurantLinks()->count();

            if ($horizonCount > 1) {
                $productHasManyHorizon[] = $product;
            }

            if ($frestaurantCount > 1) {
                $productHasManyFrestaurant[] = $product;
            }

            if ($horizonCount === 0) {
                $productHasNoHorizon[] = $product;
            }

            if ($frestaurantCount === 0) {
                $productHasNoFrestaurant[] = $product;
            }

            if ($horizonCount === 1 && $frestaurantCount === 1) {
                $productNormal[] = $product;
            }
        }

        foreach ($allHorizon as $horizon) {
            $productCount = $horizon->getProductLinks()->count();

            if ($productCount > 1) {
                $horizonHasManyProducts[] = $horizon;
            }

            if ($productCount === 0) {
                $horizonHasNoProducts[] = $horizon;
            }
        }

        foreach ($allFrestaurant as $frestaurant) {
            $frestaurantCount = $frestaurant->getProductLinks()->count();

            if ($frestaurantCount > 1) {
                $frestaurantHasManyProducts[] = $frestaurant;
            }

            if ($frestaurantCount === 0) {
                $frestaurantHasNoProducts[] = $frestaurant;
            }
        }

        return $this->render('page/dev/product-associations/product-associations.twig', [
            'products' => [
                'hasManyHorizon' => $productHasManyHorizon,
                'hasManyFrestaurant' => $productHasManyFrestaurant,
                'hasNoHorizon' => $productHasNoHorizon,
                'hasNoFrestaurant' => $productHasNoFrestaurant,
                'regular' => $productNormal,
            ],
            'horizon' => [
                'hasManyProducts' => $horizonHasManyProducts,
                'hasNoProducts' => $horizonHasNoProducts,
            ],
            'frestaurant' => [
                'hasManyProducts' => $frestaurantHasManyProducts,
                'hasNoProducts' => $frestaurantHasNoProducts,
            ],
        ]);
    }
}
