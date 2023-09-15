<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230913111402 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sub_menu DROP FOREIGN KEY FK_5A93A552BE9F9D54');
        $this->addSql('ALTER TABLE sub_menu ADD CONSTRAINT FK_5A93A552BE9F9D54 FOREIGN KEY (parent_menu_id) REFERENCES menu (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sub_menu DROP FOREIGN KEY FK_5A93A552BE9F9D54');
        $this->addSql('ALTER TABLE sub_menu ADD CONSTRAINT FK_5A93A552BE9F9D54 FOREIGN KEY (parent_menu_id) REFERENCES menu (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
