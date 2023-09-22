<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230921202918 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bullet_list ADD parent_page_id INT NOT NULL');
        $this->addSql('ALTER TABLE bullet_list ADD CONSTRAINT FK_D8BE44067E0E17A2 FOREIGN KEY (parent_page_id) REFERENCES page (id)');
        $this->addSql('CREATE INDEX IDX_D8BE44067E0E17A2 ON bullet_list (parent_page_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bullet_list DROP FOREIGN KEY FK_D8BE44067E0E17A2');
        $this->addSql('DROP INDEX IDX_D8BE44067E0E17A2 ON bullet_list');
        $this->addSql('ALTER TABLE bullet_list DROP parent_page_id');
    }
}
