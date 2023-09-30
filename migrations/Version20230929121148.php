<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230929121148 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `member` ADD CONSTRAINT FK_70E4FA78CCF9E01E FOREIGN KEY (departement_id) REFERENCES section_group (id)');
        $this->addSql('CREATE INDEX IDX_70E4FA78CCF9E01E ON `member` (departement_id)');
        $this->addSql('ALTER TABLE section_group ADD position INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `member` DROP FOREIGN KEY FK_70E4FA78CCF9E01E');
        $this->addSql('DROP INDEX IDX_70E4FA78CCF9E01E ON `member`');
        $this->addSql('ALTER TABLE section_group DROP position');
    }
}
