<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230920190625 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE page ADD parent_menu_id INT NOT NULL');
        $this->addSql('ALTER TABLE page ADD CONSTRAINT FK_140AB620BE9F9D54 FOREIGN KEY (parent_menu_id) REFERENCES main_menu (id)');
        $this->addSql('CREATE INDEX IDX_140AB620BE9F9D54 ON page (parent_menu_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE page DROP FOREIGN KEY FK_140AB620BE9F9D54');
        $this->addSql('DROP INDEX IDX_140AB620BE9F9D54 ON page');
        $this->addSql('ALTER TABLE page DROP parent_menu_id');
    }
}
