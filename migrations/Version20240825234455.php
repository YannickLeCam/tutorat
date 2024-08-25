<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240825234455 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE faculte (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE filleul ADD faculte_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE filleul ADD CONSTRAINT FK_2F9383CF72C3434F FOREIGN KEY (faculte_id) REFERENCES faculte (id)');
        $this->addSql('CREATE INDEX IDX_2F9383CF72C3434F ON filleul (faculte_id)');
        $this->addSql('ALTER TABLE parrain ADD faculte_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE parrain ADD CONSTRAINT FK_A7A835B472C3434F FOREIGN KEY (faculte_id) REFERENCES faculte (id)');
        $this->addSql('CREATE INDEX IDX_A7A835B472C3434F ON parrain (faculte_id)');
        $this->addSql('ALTER TABLE top ADD faculte_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE top ADD CONSTRAINT FK_1ED91FCA72C3434F FOREIGN KEY (faculte_id) REFERENCES faculte (id)');
        $this->addSql('CREATE INDEX IDX_1ED91FCA72C3434F ON top (faculte_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE filleul DROP FOREIGN KEY FK_2F9383CF72C3434F');
        $this->addSql('ALTER TABLE parrain DROP FOREIGN KEY FK_A7A835B472C3434F');
        $this->addSql('ALTER TABLE top DROP FOREIGN KEY FK_1ED91FCA72C3434F');
        $this->addSql('DROP TABLE faculte');
        $this->addSql('DROP INDEX IDX_1ED91FCA72C3434F ON top');
        $this->addSql('ALTER TABLE top DROP faculte_id');
        $this->addSql('DROP INDEX IDX_2F9383CF72C3434F ON filleul');
        $this->addSql('ALTER TABLE filleul DROP faculte_id');
        $this->addSql('DROP INDEX IDX_A7A835B472C3434F ON parrain');
        $this->addSql('ALTER TABLE parrain DROP faculte_id');
    }
}
