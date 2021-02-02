<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200724151915 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE achat (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE achat_product (achat_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_38804BF2FE95D117 (achat_id), INDEX IDX_38804BF24584665A (product_id), PRIMARY KEY(achat_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE achat_product ADD CONSTRAINT FK_38804BF2FE95D117 FOREIGN KEY (achat_id) REFERENCES achat (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE achat_product ADD CONSTRAINT FK_38804BF24584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE achat_product DROP FOREIGN KEY FK_38804BF2FE95D117');
        $this->addSql('DROP TABLE achat');
        $this->addSql('DROP TABLE achat_product');
    }
}
