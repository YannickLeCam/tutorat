<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240830231849 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE top_appreciation (id INT AUTO_INCREMENT NOT NULL, filleul_id INT DEFAULT NULL, top_id INT DEFAULT NULL, appreciation VARCHAR(255) NOT NULL, INDEX IDX_12CE7B70851A1D14 (filleul_id), INDEX IDX_12CE7B70C82CB256 (top_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE top_appreciation ADD CONSTRAINT FK_12CE7B70851A1D14 FOREIGN KEY (filleul_id) REFERENCES filleul (id)');
        $this->addSql('ALTER TABLE top_appreciation ADD CONSTRAINT FK_12CE7B70C82CB256 FOREIGN KEY (top_id) REFERENCES top (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE top_appreciation DROP FOREIGN KEY FK_12CE7B70851A1D14');
        $this->addSql('ALTER TABLE top_appreciation DROP FOREIGN KEY FK_12CE7B70C82CB256');
        $this->addSql('DROP TABLE top_appreciation');
    }
}
