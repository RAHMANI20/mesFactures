<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220505095046 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE deposit (id INT AUTO_INCREMENT NOT NULL, quotation_id INT NOT NULL, compte_bancaire_id INT DEFAULT NULL, montant_payer DOUBLE PRECISION NOT NULL, tva_non_applicable TINYINT(1) NOT NULL, tva DOUBLE PRECISION DEFAULT NULL, condition_reglement VARCHAR(30) NOT NULL, mode_reglement VARCHAR(40) NOT NULL, interet_retard VARCHAR(40) NOT NULL, text_introduction LONGTEXT DEFAULT NULL, text_conclusion LONGTEXT DEFAULT NULL, pied_page LONGTEXT DEFAULT NULL, INDEX IDX_95DB9D39B4EA4E60 (quotation_id), INDEX IDX_95DB9D39AF1E371E (compte_bancaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE deposit ADD CONSTRAINT FK_95DB9D39B4EA4E60 FOREIGN KEY (quotation_id) REFERENCES quotation (id)');
        $this->addSql('ALTER TABLE deposit ADD CONSTRAINT FK_95DB9D39AF1E371E FOREIGN KEY (compte_bancaire_id) REFERENCES bank_account (id)');

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE deposit');
    }
}
