<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211027204120 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE page_visits (id INT AUTO_INCREMENT NOT NULL, hash_id INT NOT NULL, visit_time DATETIME NOT NULL, INDEX IDX_2B9ECFF43F7D58D2 (hash_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_general_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pages (id INT AUTO_INCREMENT NOT NULL, hash VARCHAR(32) NOT NULL, url VARCHAR(255) NOT NULL, last_activity DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_general_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE page_visits ADD CONSTRAINT FK_2B9ECFF43F7D58D2 FOREIGN KEY (hash_id) REFERENCES pages (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE page_visits DROP FOREIGN KEY FK_2B9ECFF43F7D58D2');
        $this->addSql('DROP TABLE page_visits');
        $this->addSql('DROP TABLE pages');
    }
}
