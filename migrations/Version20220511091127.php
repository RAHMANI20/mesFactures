<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220511091127 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bill_credit (id INT AUTO_INCREMENT NOT NULL, business_client_id INT DEFAULT NULL, particular_client_id INT DEFAULT NULL, company_id INT DEFAULT NULL, compte_bancaire_id INT DEFAULT NULL, devise VARCHAR(40) NOT NULL, condition_reglement VARCHAR(30) NOT NULL, mode_reglement VARCHAR(40) NOT NULL, interet_retard VARCHAR(40) NOT NULL, text_introduction LONGTEXT DEFAULT NULL, text_conclusion LONGTEXT DEFAULT NULL, pied_page LONGTEXT DEFAULT NULL, tva_non_applicable TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, finalization_at DATETIME DEFAULT NULL, state VARCHAR(30) NOT NULL, last_update DATETIME NOT NULL, numerotation BIGINT DEFAULT NULL, INDEX IDX_B4020E88F6F5E (business_client_id), INDEX IDX_B4020E848C1B5F7 (particular_client_id), INDEX IDX_B4020E8979B1AD6 (company_id), INDEX IDX_B4020E8AF1E371E (compte_bancaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bill_credit ADD CONSTRAINT FK_B4020E88F6F5E FOREIGN KEY (business_client_id) REFERENCES business_client (id)');
        $this->addSql('ALTER TABLE bill_credit ADD CONSTRAINT FK_B4020E848C1B5F7 FOREIGN KEY (particular_client_id) REFERENCES particular_client (id)');
        $this->addSql('ALTER TABLE bill_credit ADD CONSTRAINT FK_B4020E8979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE bill_credit ADD CONSTRAINT FK_B4020E8AF1E371E FOREIGN KEY (compte_bancaire_id) REFERENCES bank_account (id)');
        $this->addSql('ALTER TABLE article ADD bill_credit_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E666F9750B9 FOREIGN KEY (type_article_id) REFERENCES type_article (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E6622E82111 FOREIGN KEY (bill_credit_id) REFERENCES bill_credit (id)');
        $this->addSql('CREATE INDEX IDX_23A0E666F9750B9 ON article (type_article_id)');
        $this->addSql('CREATE INDEX IDX_23A0E6622E82111 ON article (bill_credit_id)');
        $this->addSql('ALTER TABLE disbursement ADD bill_credit_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE disbursement ADD CONSTRAINT FK_7C96A2A122E82111 FOREIGN KEY (bill_credit_id) REFERENCES bill_credit (id)');
        $this->addSql('CREATE INDEX IDX_7C96A2A122E82111 ON disbursement (bill_credit_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E6622E82111');
        $this->addSql('ALTER TABLE disbursement DROP FOREIGN KEY FK_7C96A2A122E82111');
        $this->addSql('DROP TABLE bill_credit');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E666F9750B9');
        $this->addSql('DROP INDEX IDX_23A0E666F9750B9 ON article');
        $this->addSql('DROP INDEX IDX_23A0E6622E82111 ON article');
        $this->addSql('ALTER TABLE article DROP bill_credit_id');
        $this->addSql('DROP INDEX IDX_7C96A2A122E82111 ON disbursement');
        $this->addSql('ALTER TABLE disbursement DROP bill_credit_id');
    }
}
