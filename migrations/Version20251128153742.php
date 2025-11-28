<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251128153742 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE corrections ADD user_id INT NOT NULL, ADD chapitres_id INT NOT NULL');
        $this->addSql('ALTER TABLE corrections ADD CONSTRAINT FK_DE166914A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE corrections ADD CONSTRAINT FK_DE16691420B9AB7E FOREIGN KEY (chapitres_id) REFERENCES chapitres (id)');
        $this->addSql('CREATE INDEX IDX_DE166914A76ED395 ON corrections (user_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DE16691420B9AB7E ON corrections (chapitres_id)');
        $this->addSql('ALTER TABLE histoires ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE histoires ADD CONSTRAINT FK_589A52ACA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_589A52ACA76ED395 ON histoires (user_id)');
        $this->addSql('ALTER TABLE likes ADD user_id INT NOT NULL, ADD histoires_id INT NOT NULL');
        $this->addSql('ALTER TABLE likes ADD CONSTRAINT FK_49CA4E7DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE likes ADD CONSTRAINT FK_49CA4E7D2E7424E0 FOREIGN KEY (histoires_id) REFERENCES histoires (id)');
        $this->addSql('CREATE INDEX IDX_49CA4E7DA76ED395 ON likes (user_id)');
        $this->addSql('CREATE INDEX IDX_49CA4E7D2E7424E0 ON likes (histoires_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE corrections DROP FOREIGN KEY FK_DE166914A76ED395');
        $this->addSql('ALTER TABLE corrections DROP FOREIGN KEY FK_DE16691420B9AB7E');
        $this->addSql('DROP INDEX IDX_DE166914A76ED395 ON corrections');
        $this->addSql('DROP INDEX UNIQ_DE16691420B9AB7E ON corrections');
        $this->addSql('ALTER TABLE corrections DROP user_id, DROP chapitres_id');
        $this->addSql('ALTER TABLE histoires DROP FOREIGN KEY FK_589A52ACA76ED395');
        $this->addSql('DROP INDEX UNIQ_589A52ACA76ED395 ON histoires');
        $this->addSql('ALTER TABLE histoires DROP user_id');
        $this->addSql('ALTER TABLE likes DROP FOREIGN KEY FK_49CA4E7DA76ED395');
        $this->addSql('ALTER TABLE likes DROP FOREIGN KEY FK_49CA4E7D2E7424E0');
        $this->addSql('DROP INDEX IDX_49CA4E7DA76ED395 ON likes');
        $this->addSql('DROP INDEX IDX_49CA4E7D2E7424E0 ON likes');
        $this->addSql('ALTER TABLE likes DROP user_id, DROP histoires_id');
    }
}
