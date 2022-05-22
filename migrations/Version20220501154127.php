<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220501154127 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs

        $this->addSql('ALTER TABLE quotation ADD business_client_id INT DEFAULT NULL, ADD particular_client_id INT DEFAULT NULL, ADD company_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE quotation ADD CONSTRAINT FK_474A8DB98F6F5E FOREIGN KEY (business_client_id) REFERENCES business_client (id)');
        $this->addSql('ALTER TABLE quotation ADD CONSTRAINT FK_474A8DB948C1B5F7 FOREIGN KEY (particular_client_id) REFERENCES particular_client (id)');
        $this->addSql('ALTER TABLE quotation ADD CONSTRAINT FK_474A8DB9979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('CREATE INDEX IDX_474A8DB98F6F5E ON quotation (business_client_id)');
        $this->addSql('CREATE INDEX IDX_474A8DB948C1B5F7 ON quotation (particular_client_id)');
        $this->addSql('CREATE INDEX IDX_474A8DB9979B1AD6 ON quotation (company_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article CHANGE type type VARCHAR(8) DEFAULT NULL');
        $this->addSql('ALTER TABLE quotation DROP FOREIGN KEY FK_474A8DB98F6F5E');
        $this->addSql('ALTER TABLE quotation DROP FOREIGN KEY FK_474A8DB948C1B5F7');
        $this->addSql('ALTER TABLE quotation DROP FOREIGN KEY FK_474A8DB9979B1AD6');
        $this->addSql('DROP INDEX IDX_474A8DB98F6F5E ON quotation');
        $this->addSql('DROP INDEX IDX_474A8DB948C1B5F7 ON quotation');
        $this->addSql('DROP INDEX IDX_474A8DB9979B1AD6 ON quotation');
        $this->addSql('ALTER TABLE quotation DROP business_client_id, DROP particular_client_id, DROP company_id, CHANGE condition_reglement condition_reglement VARCHAR(30) DEFAULT NULL, CHANGE mode_reglement mode_reglement VARCHAR(40) DEFAULT NULL, CHANGE interet_retard interet_retard VARCHAR(40) DEFAULT NULL');
    }
}
