<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220609120011 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category_subcategory (category_id INT NOT NULL, subcategory_id INT NOT NULL, INDEX IDX_BA47E62312469DE2 (category_id), INDEX IDX_BA47E6235DC6FE57 (subcategory_id), PRIMARY KEY(category_id, subcategory_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE category_subcategory ADD CONSTRAINT FK_BA47E62312469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category_subcategory ADD CONSTRAINT FK_BA47E6235DC6FE57 FOREIGN KEY (subcategory_id) REFERENCES subcategory (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE order_product CHANGE order_id order_id INT NOT NULL, CHANGE product_id product_id INT NOT NULL');
        $this->addSql('ALTER TABLE shopping_cart_product CHANGE shopping_cart_id shopping_cart_id INT NOT NULL, CHANGE product_id product_id INT NOT NULL');
        $this->addSql('ALTER TABLE subcategory DROP FOREIGN KEY FK_DDCA44812469DE2');
        $this->addSql('DROP INDEX IDX_DDCA44812469DE2 ON subcategory');
        $this->addSql('ALTER TABLE subcategory DROP category_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE category_subcategory');
        $this->addSql('ALTER TABLE order_product CHANGE product_id product_id INT DEFAULT NULL, CHANGE order_id order_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE shopping_cart_product CHANGE product_id product_id INT DEFAULT NULL, CHANGE shopping_cart_id shopping_cart_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE subcategory ADD category_id INT NOT NULL');
        $this->addSql('ALTER TABLE subcategory ADD CONSTRAINT FK_DDCA44812469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_DDCA44812469DE2 ON subcategory (category_id)');
    }
}
