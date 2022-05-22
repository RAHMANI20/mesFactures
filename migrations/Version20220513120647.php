<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220513120647 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE preference_general ADD type_article_id INT DEFAULT NULL, ADD devise VARCHAR(40) DEFAULT NULL');
        $this->addSql('ALTER TABLE preference_general ADD CONSTRAINT FK_AEC5395A6F9750B9 FOREIGN KEY (type_article_id) REFERENCES type_article (id)');
        $this->addSql('CREATE INDEX IDX_AEC5395A6F9750B9 ON preference_general (type_article_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE preference_general DROP FOREIGN KEY FK_AEC5395A6F9750B9');
        $this->addSql('DROP INDEX IDX_AEC5395A6F9750B9 ON preference_general');
        $this->addSql('ALTER TABLE preference_general DROP type_article_id, DROP devise');
    }
}
