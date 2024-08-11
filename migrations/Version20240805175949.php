<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240805175949 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product_product_frestaurant (product_id INT NOT NULL, product_frestaurant_id INT NOT NULL, PRIMARY KEY(product_id, product_frestaurant_id))');
        $this->addSql('CREATE INDEX IDX_2E97E2534584665A ON product_product_frestaurant (product_id)');
        $this->addSql('CREATE INDEX IDX_2E97E253485EF598 ON product_product_frestaurant (product_frestaurant_id)');
        $this->addSql('CREATE TABLE product_product_horizon (product_id INT NOT NULL, product_horizon_id INT NOT NULL, PRIMARY KEY(product_id, product_horizon_id))');
        $this->addSql('CREATE INDEX IDX_EBF0A3C94584665A ON product_product_horizon (product_id)');
        $this->addSql('CREATE INDEX IDX_EBF0A3C9327EF05E ON product_product_horizon (product_horizon_id)');
        $this->addSql('ALTER TABLE product_product_frestaurant ADD CONSTRAINT FK_2E97E2534584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE product_product_frestaurant ADD CONSTRAINT FK_2E97E253485EF598 FOREIGN KEY (product_frestaurant_id) REFERENCES product_frestaurant (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE product_product_horizon ADD CONSTRAINT FK_EBF0A3C94584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE product_product_horizon ADD CONSTRAINT FK_EBF0A3C9327EF05E FOREIGN KEY (product_horizon_id) REFERENCES product_horizon (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE product_product_frestaurant DROP CONSTRAINT FK_2E97E2534584665A');
        $this->addSql('ALTER TABLE product_product_frestaurant DROP CONSTRAINT FK_2E97E253485EF598');
        $this->addSql('ALTER TABLE product_product_horizon DROP CONSTRAINT FK_EBF0A3C94584665A');
        $this->addSql('ALTER TABLE product_product_horizon DROP CONSTRAINT FK_EBF0A3C9327EF05E');
        $this->addSql('DROP TABLE product_product_frestaurant');
        $this->addSql('DROP TABLE product_product_horizon');
    }
}
