<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220415102332 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE company (id INT AUTO_INCREMENT NOT NULL, langue_id INT NOT NULL, nom VARCHAR(150) NOT NULL, num_tva VARCHAR(13) DEFAULT NULL, siret VARCHAR(14) DEFAULT NULL, code_naf VARCHAR(5) DEFAULT NULL, adresse VARCHAR(180) DEFAULT NULL, complement_adresse VARCHAR(180) DEFAULT NULL, code_postal VARCHAR(5) DEFAULT NULL, ville VARCHAR(100) DEFAULT NULL, pays VARCHAR(100) DEFAULT NULL, num_telephone VARCHAR(20) DEFAULT NULL, site_internet VARCHAR(100) DEFAULT NULL, INDEX IDX_4FBF094F2AADBACD (langue_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE company ADD CONSTRAINT FK_4FBF094F2AADBACD FOREIGN KEY (langue_id) REFERENCES language (id)');
        $this->addSql('ALTER TABLE users CHANGE societe societe VARCHAR(150) NOT NULL, CHANGE siret siret VARCHAR(14) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE company');
        $this->addSql('ALTER TABLE users CHANGE societe societe VARCHAR(150) DEFAULT NULL, CHANGE siret siret VARCHAR(14) DEFAULT NULL');
    }
}
