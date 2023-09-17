<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230915125744 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE home_page_key_value ADD home_page_id INT NOT NULL');
        $this->addSql('ALTER TABLE home_page_key_value ADD CONSTRAINT FK_44DF423FB966A8BC FOREIGN KEY (home_page_id) REFERENCES home_page (id)');
        $this->addSql('CREATE INDEX IDX_44DF423FB966A8BC ON home_page_key_value (home_page_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE home_page_key_value DROP FOREIGN KEY FK_44DF423FB966A8BC');
        $this->addSql('DROP INDEX IDX_44DF423FB966A8BC ON home_page_key_value');
        $this->addSql('ALTER TABLE home_page_key_value DROP home_page_id');
    }
}
