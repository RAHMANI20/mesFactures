<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220419175228 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE business_client CHANGE langue_id langue_id INT NOT NULL, CHANGE societe_id societe_id INT NOT NULL');
        $this->addSql('ALTER TABLE company CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE business_client CHANGE langue_id langue_id INT DEFAULT NULL, CHANGE societe_id societe_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE company CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP');
    }
}
