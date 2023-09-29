<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230926205426 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE member_section (member_id INT NOT NULL, section_id INT NOT NULL, INDEX IDX_9287CD7B7597D3FE (member_id), INDEX IDX_9287CD7BD823E37A (section_id), PRIMARY KEY(member_id, section_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE member_section ADD CONSTRAINT FK_9287CD7B7597D3FE FOREIGN KEY (member_id) REFERENCES `member` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE member_section ADD CONSTRAINT FK_9287CD7BD823E37A FOREIGN KEY (section_id) REFERENCES section (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE member_section DROP FOREIGN KEY FK_9287CD7B7597D3FE');
        $this->addSql('ALTER TABLE member_section DROP FOREIGN KEY FK_9287CD7BD823E37A');
        $this->addSql('DROP TABLE member_section');
    }
}
