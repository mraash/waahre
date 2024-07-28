<?php

declare(strict_types=1);

namespace App\Cli\Command;

use RuntimeException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand('app:database:reset')]
class ResetDatabaseCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Some poopy code in command class...

        $app = $this->getApplication() ?? throw new RuntimeException('Application is null.');

        // database.drop
        $dropInput = new ArrayInput([
            '-f' => true,
        ]);

        $dropOutput = new BufferedOutput();

        $dropCode = $app->find('doctrine:database:drop')->run($dropInput, $dropOutput);

        if ($dropCode !== Command::SUCCESS) {
            $output->write('<error>' . $dropOutput->fetch() . '</error>');
            return $dropCode;
        }

        // database.create
        $createOutput = new BufferedOutput();

        $createCode = $app->find('doctrine:database:create')->run(new ArrayInput([]), $createOutput);

        if ($createCode !== Command::SUCCESS) {
            $output->write('<error>' . $createOutput->fetch() . '</error>');
            return $createCode;
        }

        // migrations.migrate
        $migrationsOutput = new BufferedOutput();

        $migrationsInput = new ArrayInput([]);
        $migrationsInput->setInteractive(false);

        $mCode = $app->find('doctrine:migrations:migrate')->run($migrationsInput, $migrationsOutput);

        if ($mCode !== Command::SUCCESS) {
            $output->write('<error>' . $migrationsOutput->fetch() . '</error>');
            return $mCode;
        }

        $output->writeln('<info>ok...</>');
        return Command::SUCCESS;
    }
}
