<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241120191648 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE note_etudiant (id INT AUTO_INCREMENT NOT NULL, filleul_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, date DATE NOT NULL, note DOUBLE PRECISION DEFAULT NULL, total_points DOUBLE PRECISION NOT NULL, rang INT DEFAULT NULL, INDEX IDX_6125FE7D851A1D14 (filleul_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE note_etudiant ADD CONSTRAINT FK_6125FE7D851A1D14 FOREIGN KEY (filleul_id) REFERENCES filleul (id)');
        $this->addSql('ALTER TABLE filleul DROP mail, DROP telephone');
        $this->addSql('ALTER TABLE top_appreciation CHANGE appreciation appreciation VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE note_etudiant DROP FOREIGN KEY FK_6125FE7D851A1D14');
        $this->addSql('DROP TABLE note_etudiant');
        $this->addSql('ALTER TABLE top_appreciation CHANGE appreciation appreciation LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE filleul ADD mail VARCHAR(255) DEFAULT NULL, ADD telephone VARCHAR(15) DEFAULT NULL');
    }
}
