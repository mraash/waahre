<?php

namespace App\Cli\Command;

use App\Data\Repository\ProductFRestaurantRepository;
use App\Data\Repository\ProductHorizonRepository;
use App\Data\Repository\ProductRepository;
use App\Domain\Service\Seeder\ProductSeeder;
use App\Domain\Service\Seeder\ProductFRestaurantSeeder;
use App\Domain\Service\Seeder\ProductHorizonSeeder;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:products:refill',
    description: 'Add a short description for your command',
)]
class RefillProductsCommand extends Command
{
    public function __construct(
        private readonly ProductSeeder $productSeeder,
        private readonly ProductHorizonSeeder $productHorizonSeeder,
        private readonly ProductFRestaurantSeeder $productFRestaurantSeeder,
        private readonly ProductRepository $productRepository,
        private readonly ProductHorizonRepository $productHorizonRepository,
        private readonly ProductFRestaurantRepository $productFRestaurantRepository,
        private string $projectDir,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $horizonFilename = "{$this->projectDir}/data/db-seeds/products-horizon.xlsx";
        $frestaurantFilename = "{$this->projectDir}/data/db-seeds/products-4restaurant.html";

        $this->productRepository->deleteList($this->productRepository->findAll());
        $this->productHorizonRepository->deleteList($this->productHorizonRepository->findAll());
        $this->productFRestaurantRepository->deleteList($this->productFRestaurantRepository->findAll());
        $this->productRepository->flush();

        $this->productHorizonSeeder->fillDbTableFromProductListFile($horizonFilename);
        $this->productRepository->flush();

        $this->productSeeder->fillDbTableByCopyingHroizonProducts();
        $this->productRepository->flush();

        $this->productFRestaurantSeeder->fillDbTableByProductListFile($frestaurantFilename);
        $this->productRepository->flush();

        $this->productFRestaurantSeeder->linkAllWithProducts();
        $this->productRepository->flush();

        $output->writeln('<info>ok...</>');

        return Command::SUCCESS;
    }
}
