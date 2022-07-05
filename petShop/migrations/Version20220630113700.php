<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220630113700 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category_subcategory ADD CONSTRAINT FK_BA47E62312469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE category_subcategory ADD CONSTRAINT FK_BA47E6235DC6FE57 FOREIGN KEY (subcategory_id) REFERENCES subcategory (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADBCD6BD6A FOREIGN KEY (category_subcategory_id) REFERENCES category_subcategory (id)');
        $this->addSql('CREATE INDEX IDX_D34A04ADBCD6BD6A ON product (category_subcategory_id)');
        $this->addSql('ALTER TABLE user CHANGE phone_number phone_number VARCHAR(10) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category_subcategory DROP FOREIGN KEY FK_BA47E62312469DE2');
        $this->addSql('ALTER TABLE category_subcategory DROP FOREIGN KEY FK_BA47E6235DC6FE57');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADBCD6BD6A');
        $this->addSql('DROP INDEX IDX_D34A04ADBCD6BD6A ON product');
        $this->addSql('ALTER TABLE user CHANGE phone_number phone_number INT NOT NULL');
    }
}
