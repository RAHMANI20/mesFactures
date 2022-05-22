<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220506200726 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bill (id INT AUTO_INCREMENT NOT NULL, compte_bancaire_id INT DEFAULT NULL, business_client_id INT DEFAULT NULL, particular_client_id INT DEFAULT NULL, company_id INT DEFAULT NULL, devise VARCHAR(40) NOT NULL, condition_reglement VARCHAR(30) NOT NULL, mode_reglement VARCHAR(40) NOT NULL, interet_retard VARCHAR(40) NOT NULL, text_introduction LONGTEXT DEFAULT NULL, text_conclusion LONGTEXT DEFAULT NULL, pied_page LONGTEXT DEFAULT NULL, tva_non_applicable TINYINT(1) NOT NULL, state VARCHAR(30) NOT NULL, created_at DATETIME NOT NULL, last_update DATETIME NOT NULL, finalization_at DATETIME DEFAULT NULL, payed_at DATETIME DEFAULT NULL, INDEX IDX_7A2119E3AF1E371E (compte_bancaire_id), INDEX IDX_7A2119E38F6F5E (business_client_id), INDEX IDX_7A2119E348C1B5F7 (particular_client_id), INDEX IDX_7A2119E3979B1AD6 (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE disbursement (id INT AUTO_INCREMENT NOT NULL, bill_id INT DEFAULT NULL, reference_facture VARCHAR(100) DEFAULT NULL, montant_ht DOUBLE PRECISION NOT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_7C96A2A11A8C12F5 (bill_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_article (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bill ADD CONSTRAINT FK_7A2119E3AF1E371E FOREIGN KEY (compte_bancaire_id) REFERENCES bank_account (id)');
        $this->addSql('ALTER TABLE bill ADD CONSTRAINT FK_7A2119E38F6F5E FOREIGN KEY (business_client_id) REFERENCES business_client (id)');
        $this->addSql('ALTER TABLE bill ADD CONSTRAINT FK_7A2119E348C1B5F7 FOREIGN KEY (particular_client_id) REFERENCES particular_client (id)');
        $this->addSql('ALTER TABLE bill ADD CONSTRAINT FK_7A2119E3979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE disbursement ADD CONSTRAINT FK_7C96A2A11A8C12F5 FOREIGN KEY (bill_id) REFERENCES bill (id)');
        $this->addSql('ALTER TABLE article ADD bill_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E661A8C12F5 FOREIGN KEY (bill_id) REFERENCES bill (id)');
        $this->addSql('CREATE INDEX IDX_23A0E661A8C12F5 ON article (bill_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E661A8C12F5');
        $this->addSql('ALTER TABLE disbursement DROP FOREIGN KEY FK_7C96A2A11A8C12F5');
        $this->addSql('DROP TABLE bill');
        $this->addSql('DROP TABLE disbursement');
        $this->addSql('DROP TABLE type_article');
        $this->addSql('DROP INDEX IDX_23A0E661A8C12F5 ON article');
        $this->addSql('ALTER TABLE article DROP bill_id');
    }
}
