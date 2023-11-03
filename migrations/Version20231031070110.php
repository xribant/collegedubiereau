<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231031070110 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE info_registration (id INT AUTO_INCREMENT NOT NULL, info_session_day_id INT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, child_number INT NOT NULL, INDEX IDX_4F7570009F580BFB (info_session_day_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE info_registration_section (info_registration_id INT NOT NULL, section_id INT NOT NULL, INDEX IDX_341F18536911393A (info_registration_id), INDEX IDX_341F1853D823E37A (section_id), PRIMARY KEY(info_registration_id, section_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE info_registration ADD CONSTRAINT FK_4F7570009F580BFB FOREIGN KEY (info_session_day_id) REFERENCES info_session_day (id)');
        $this->addSql('ALTER TABLE info_registration_section ADD CONSTRAINT FK_341F18536911393A FOREIGN KEY (info_registration_id) REFERENCES info_registration (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE info_registration_section ADD CONSTRAINT FK_341F1853D823E37A FOREIGN KEY (section_id) REFERENCES section (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE info_registration DROP FOREIGN KEY FK_4F7570009F580BFB');
        $this->addSql('ALTER TABLE info_registration_section DROP FOREIGN KEY FK_341F18536911393A');
        $this->addSql('ALTER TABLE info_registration_section DROP FOREIGN KEY FK_341F1853D823E37A');
        $this->addSql('DROP TABLE info_registration');
        $this->addSql('DROP TABLE info_registration_section');
    }
}
