<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240806141337 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP CONSTRAINT fk_d34a04ad136380b3');
        $this->addSql('DROP INDEX uniq_d34a04ad136380b3');
        $this->addSql('ALTER TABLE product DROP horizon_twin_id');
        $this->addSql('ALTER TABLE product_frestaurant DROP CONSTRAINT fk_77d609c1d8629a9c');
        $this->addSql('DROP INDEX idx_77d609c1d8629a9c');
        $this->addSql('ALTER TABLE product_frestaurant DROP local_twin_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE product ADD horizon_twin_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT fk_d34a04ad136380b3 FOREIGN KEY (horizon_twin_id) REFERENCES product_horizon (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX uniq_d34a04ad136380b3 ON product (horizon_twin_id)');
        $this->addSql('ALTER TABLE product_frestaurant ADD local_twin_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product_frestaurant ADD CONSTRAINT fk_77d609c1d8629a9c FOREIGN KEY (local_twin_id) REFERENCES product (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_77d609c1d8629a9c ON product_frestaurant (local_twin_id)');
    }
}
