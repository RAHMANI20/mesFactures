<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220415131754 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE business_client (id INT AUTO_INCREMENT NOT NULL, langue_id INT NOT NULL, societe_id INT NOT NULL, email VARCHAR(180) DEFAULT NULL, prenom VARCHAR(100) NOT NULL, nom VARCHAR(100) NOT NULL, fonction VARCHAR(50) DEFAULT NULL, num_telephone VARCHAR(20) DEFAULT NULL, INDEX IDX_9CE44BAF2AADBACD (langue_id), INDEX IDX_9CE44BAFFCF77503 (societe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE business_client ADD CONSTRAINT FK_9CE44BAF2AADBACD FOREIGN KEY (langue_id) REFERENCES language (id)');
        $this->addSql('ALTER TABLE business_client ADD CONSTRAINT FK_9CE44BAFFCF77503 FOREIGN KEY (societe_id) REFERENCES company (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE business_client');
    }
}
