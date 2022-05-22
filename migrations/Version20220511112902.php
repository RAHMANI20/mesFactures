<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220511112902 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bill_credit DROP FOREIGN KEY FK_B4020E8AF1E371E');
        $this->addSql('DROP INDEX IDX_B4020E8AF1E371E ON bill_credit');
        $this->addSql('ALTER TABLE bill_credit DROP compte_bancaire_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bill_credit ADD compte_bancaire_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bill_credit ADD CONSTRAINT FK_B4020E8AF1E371E FOREIGN KEY (compte_bancaire_id) REFERENCES bank_account (id)');
        $this->addSql('CREATE INDEX IDX_B4020E8AF1E371E ON bill_credit (compte_bancaire_id)');
    }
}
