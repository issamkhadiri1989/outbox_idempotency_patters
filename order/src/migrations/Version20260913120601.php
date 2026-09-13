<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260913120601 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE order_item (id INT AUTO_INCREMENT NOT NULL, requested_quantity INT NOT NULL, unit_price DOUBLE PRECISION NOT NULL, product_id BINARY(16) NOT NULL, owner_order_id BINARY(16) NOT NULL, INDEX IDX_52EA1F094584665A (product_id), INDEX IDX_52EA1F099B7FD4FB (owner_order_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE `orders` (id BINARY(16) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, status VARCHAR(255) DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE product (id BINARY(16) NOT NULL, name VARCHAR(255) NOT NULL, unit_price DOUBLE PRECISION NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F094584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F099B7FD4FB FOREIGN KEY (owner_order_id) REFERENCES `orders` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_item DROP FOREIGN KEY FK_52EA1F094584665A');
        $this->addSql('ALTER TABLE order_item DROP FOREIGN KEY FK_52EA1F099B7FD4FB');
        $this->addSql('DROP TABLE order_item');
        $this->addSql('DROP TABLE `orders`');
        $this->addSql('DROP TABLE product');
    }
}
