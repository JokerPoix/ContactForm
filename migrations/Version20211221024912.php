<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211221024912 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE applicant_request (id INT AUTO_INCREMENT NOT NULL, applicant_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, question VARCHAR(1000) NOT NULL, answered TINYINT(1) NOT NULL, additionnal_informations VARCHAR(1000) DEFAULT NULL, INDEX IDX_4DD22A6697139001 (applicant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE applicant_request ADD CONSTRAINT FK_4DD22A6697139001 FOREIGN KEY (applicant_id) REFERENCES applicant (id)');
        $this->addSql('DROP TABLE request');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE request (id INT AUTO_INCREMENT NOT NULL, applicant_id INT DEFAULT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, question VARCHAR(1000) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, answered TINYINT(1) NOT NULL, additionnal_informations VARCHAR(1000) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_3B978F9F97139001 (applicant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE request ADD CONSTRAINT FK_3B978F9F97139001 FOREIGN KEY (applicant_id) REFERENCES applicant (id)');
        $this->addSql('DROP TABLE applicant_request');
    }
}
