<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240826124411 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE direction ADD faculte_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE direction ADD CONSTRAINT FK_3E4AD1B372C3434F FOREIGN KEY (faculte_id) REFERENCES faculte (id)');
        $this->addSql('CREATE INDEX IDX_3E4AD1B372C3434F ON direction (faculte_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE direction DROP FOREIGN KEY FK_3E4AD1B372C3434F');
        $this->addSql('DROP INDEX IDX_3E4AD1B372C3434F ON direction');
        $this->addSql('ALTER TABLE direction DROP faculte_id');
    }
}
