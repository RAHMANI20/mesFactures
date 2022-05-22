<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220501152419 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quotation DROP FOREIGN KEY FK_474A8DB9A4F84F6E');
        $this->addSql('DROP INDEX IDX_474A8DB9A4F84F6E ON quotation');
        $this->addSql('ALTER TABLE quotation DROP destinataire_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article CHANGE type type VARCHAR(8) DEFAULT NULL');
        $this->addSql('ALTER TABLE quotation ADD destinataire_id INT NOT NULL, CHANGE condition_reglement condition_reglement VARCHAR(30) DEFAULT NULL, CHANGE mode_reglement mode_reglement VARCHAR(40) DEFAULT NULL, CHANGE interet_retard interet_retard VARCHAR(40) DEFAULT NULL');
        $this->addSql('ALTER TABLE quotation ADD CONSTRAINT FK_474A8DB9A4F84F6E FOREIGN KEY (destinataire_id) REFERENCES business_client (id)');
        $this->addSql('CREATE INDEX IDX_474A8DB9A4F84F6E ON quotation (destinataire_id)');
    }
}
