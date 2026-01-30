<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260129135839 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE corrections ADD histoire_id INT NOT NULL');
        $this->addSql('ALTER TABLE corrections ADD CONSTRAINT FK_DE1669149B94373 FOREIGN KEY (histoire_id) REFERENCES histoires (id)');
        $this->addSql('CREATE INDEX IDX_DE1669149B94373 ON corrections (histoire_id)');
        $this->addSql('ALTER TABLE user CHANGE username username VARCHAR(40) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE corrections DROP FOREIGN KEY FK_DE1669149B94373');
        $this->addSql('DROP INDEX IDX_DE1669149B94373 ON corrections');
        $this->addSql('ALTER TABLE corrections DROP histoire_id');
        $this->addSql('ALTER TABLE user CHANGE username username VARCHAR(40) DEFAULT NULL');
    }
}
