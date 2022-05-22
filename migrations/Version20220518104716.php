<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220518104716 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE opportunity (id INT AUTO_INCREMENT NOT NULL, business_client_id INT DEFAULT NULL, particular_client_id INT DEFAULT NULL, company_id INT DEFAULT NULL, intitule VARCHAR(100) NOT NULL, montant_ht DOUBLE PRECISION NOT NULL, devise VARCHAR(40) NOT NULL, mois_signature VARCHAR(20) DEFAULT NULL, annee_signature VARCHAR(4) DEFAULT NULL, probabilite INT NOT NULL, notes LONGTEXT DEFAULT NULL, INDEX IDX_8389C3D78F6F5E (business_client_id), INDEX IDX_8389C3D748C1B5F7 (particular_client_id), INDEX IDX_8389C3D7979B1AD6 (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE opportunity ADD CONSTRAINT FK_8389C3D78F6F5E FOREIGN KEY (business_client_id) REFERENCES business_client (id)');
        $this->addSql('ALTER TABLE opportunity ADD CONSTRAINT FK_8389C3D748C1B5F7 FOREIGN KEY (particular_client_id) REFERENCES particular_client (id)');
        $this->addSql('ALTER TABLE opportunity ADD CONSTRAINT FK_8389C3D7979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE opportunity');
    }
}
