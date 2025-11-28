<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251128142635 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chapitres ADD histoires_id INT NOT NULL');
        $this->addSql('ALTER TABLE chapitres ADD CONSTRAINT FK_508679FC2E7424E0 FOREIGN KEY (histoires_id) REFERENCES histoires (id)');
        $this->addSql('CREATE INDEX IDX_508679FC2E7424E0 ON chapitres (histoires_id)');
        $this->addSql('ALTER TABLE user ADD is_verified TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chapitres DROP FOREIGN KEY FK_508679FC2E7424E0');
        $this->addSql('DROP INDEX IDX_508679FC2E7424E0 ON chapitres');
        $this->addSql('ALTER TABLE chapitres DROP histoires_id');
        $this->addSql('ALTER TABLE user DROP is_verified');
    }
}
