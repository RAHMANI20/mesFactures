<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220422161823 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, quotation_id INT NOT NULL, type VARCHAR(8) NOT NULL, quantite INT DEFAULT NULL, prix_ht DOUBLE PRECISION DEFAULT NULL, tva DOUBLE PRECISION DEFAULT NULL, reduction DOUBLE PRECISION DEFAULT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_23A0E66B4EA4E60 (quotation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quotation (id INT AUTO_INCREMENT NOT NULL, destinataire_id INT NOT NULL, duree_validite INT NOT NULL, devise VARCHAR(40) NOT NULL, condition_reglement VARCHAR(30) NOT NULL, mode_reglement VARCHAR(40) NOT NULL, interet_retard VARCHAR(40) NOT NULL, text_introduction LONGTEXT DEFAULT NULL, text_conclusion LONGTEXT DEFAULT NULL, pied_page LONGTEXT DEFAULT NULL, conditions_generales LONGTEXT DEFAULT NULL, INDEX IDX_474A8DB9A4F84F6E (destinataire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66B4EA4E60 FOREIGN KEY (quotation_id) REFERENCES quotation (id)');
        $this->addSql('ALTER TABLE quotation ADD CONSTRAINT FK_474A8DB9A4F84F6E FOREIGN KEY (destinataire_id) REFERENCES business_client (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66B4EA4E60');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE quotation');
    }
}
