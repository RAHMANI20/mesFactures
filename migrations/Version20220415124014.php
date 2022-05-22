<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220415124014 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE particular_client (id INT AUTO_INCREMENT NOT NULL, langue_id INT NOT NULL, email VARCHAR(180) DEFAULT NULL, prenom VARCHAR(100) NOT NULL, nom VARCHAR(100) NOT NULL, fonction VARCHAR(50) DEFAULT NULL, adresse VARCHAR(180) DEFAULT NULL, complement_adresse VARCHAR(180) DEFAULT NULL, code_postal VARCHAR(5) DEFAULT NULL, ville VARCHAR(100) DEFAULT NULL, pays VARCHAR(100) DEFAULT NULL, site_internet VARCHAR(100) DEFAULT NULL, num_telephone VARCHAR(20) DEFAULT NULL, INDEX IDX_F3193F182AADBACD (langue_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE particular_client ADD CONSTRAINT FK_F3193F182AADBACD FOREIGN KEY (langue_id) REFERENCES language (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE particular_client');
    }
}
