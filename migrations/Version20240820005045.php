<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240820005045 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE filleul (id INT AUTO_INCREMENT NOT NULL, mineure_id INT NOT NULL, specialite_id INT NOT NULL, parrain_id INT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, mail VARCHAR(255) NOT NULL, telephone VARCHAR(15) NOT NULL, INDEX IDX_2F9383CF66B9354C (mineure_id), INDEX IDX_2F9383CF2195E0F0 (specialite_id), INDEX IDX_2F9383CFDE2A7A37 (parrain_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mineure (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE parrain (id INT AUTO_INCREMENT NOT NULL, top_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, INDEX IDX_A7A835B4C82CB256 (top_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE parrain_appreciation (id INT AUTO_INCREMENT NOT NULL, filleul_id INT DEFAULT NULL, parrain_id INT NOT NULL, appreciation LONGTEXT NOT NULL, humeur INT NOT NULL, travail INT NOT NULL, date_creation DATE NOT NULL, INDEX IDX_ED95151D851A1D14 (filleul_id), INDEX IDX_ED95151DDE2A7A37 (parrain_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE specialite (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE top (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE filleul ADD CONSTRAINT FK_2F9383CF66B9354C FOREIGN KEY (mineure_id) REFERENCES mineure (id)');
        $this->addSql('ALTER TABLE filleul ADD CONSTRAINT FK_2F9383CF2195E0F0 FOREIGN KEY (specialite_id) REFERENCES specialite (id)');
        $this->addSql('ALTER TABLE filleul ADD CONSTRAINT FK_2F9383CFDE2A7A37 FOREIGN KEY (parrain_id) REFERENCES parrain (id)');
        $this->addSql('ALTER TABLE parrain ADD CONSTRAINT FK_A7A835B4C82CB256 FOREIGN KEY (top_id) REFERENCES top (id)');
        $this->addSql('ALTER TABLE parrain_appreciation ADD CONSTRAINT FK_ED95151D851A1D14 FOREIGN KEY (filleul_id) REFERENCES filleul (id)');
        $this->addSql('ALTER TABLE parrain_appreciation ADD CONSTRAINT FK_ED95151DDE2A7A37 FOREIGN KEY (parrain_id) REFERENCES parrain (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE filleul DROP FOREIGN KEY FK_2F9383CF66B9354C');
        $this->addSql('ALTER TABLE filleul DROP FOREIGN KEY FK_2F9383CF2195E0F0');
        $this->addSql('ALTER TABLE filleul DROP FOREIGN KEY FK_2F9383CFDE2A7A37');
        $this->addSql('ALTER TABLE parrain DROP FOREIGN KEY FK_A7A835B4C82CB256');
        $this->addSql('ALTER TABLE parrain_appreciation DROP FOREIGN KEY FK_ED95151D851A1D14');
        $this->addSql('ALTER TABLE parrain_appreciation DROP FOREIGN KEY FK_ED95151DDE2A7A37');
        $this->addSql('DROP TABLE filleul');
        $this->addSql('DROP TABLE mineure');
        $this->addSql('DROP TABLE parrain');
        $this->addSql('DROP TABLE parrain_appreciation');
        $this->addSql('DROP TABLE specialite');
        $this->addSql('DROP TABLE top');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
