<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190920013651 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'init schema';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql(
            'CREATE TABLE contacts(
              id INT AUTO_INCREMENT NOT NULL, 
              user_id INT NOT NULL, 
              last_name VARCHAR(25) NOT NULL, 
              first_name VARCHAR(25) NOT NULL, 
              email VARCHAR(25) NOT NULL, 
              INDEX IDX_33401573A76ED395 (user_id), 
              INDEX search_idx (last_name, first_name, email), 
              PRIMARY KEY(id)) 
              DEFAULT CHARACTER SET utf8mb4 
              COLLATE utf8mb4_unicode_ci ENGINE = InnoDB'
        );

        $this->addSql(
            'CREATE TABLE user (
              id INT AUTO_INCREMENT NOT NULL, 
              login VARCHAR(25) NOT NULL, 
              email VARCHAR(25) NOT NULL, 
              password VARCHAR(255) NOT NULL, 
              is_active TINYINT(1) NOT NULL, 
              UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), 
              INDEX search_idx (login, email), 
              PRIMARY KEY(id)) 
              DEFAULT CHARACTER SET utf8mb4 
              COLLATE utf8mb4_unicode_ci ENGINE = InnoDB'
        );

        $this->addSql(
            'CREATE TABLE addresses (
              id INT AUTO_INCREMENT NOT NULL, 
              contact_id INT NOT NULL, 
              number INT NOT NULL, 
              street VARCHAR(255) NOT NULL, 
              postal_code INT NOT NULL, 
              city VARCHAR(25) NOT NULL, 
              country VARCHAR(25) NOT NULL, 
              INDEX IDX_6FCA7516E7A1254A (contact_id), 
              PRIMARY KEY(id)) 
              DEFAULT CHARACTER SET utf8mb4 
              COLLATE utf8mb4_unicode_ci ENGINE = InnoDB'
        );

        $this->addSql(
            'ALTER TABLE contacts 
              ADD CONSTRAINT FK_33401573A76ED395 
              FOREIGN KEY (user_id) 
              REFERENCES user (id)'
        );
        $this->addSql(
            'ALTER TABLE addresses 
             ADD CONSTRAINT FK_6FCA7516E7A1254A 
             FOREIGN KEY (contact_id) 
             REFERENCES contacts (id)'
        );

        $this->addSql(
            "INSERT INTO user (`login`, `email`, `password`, `is_active`) 
             VALUES ('admin', 'leboncoin@test.fr', '21232f297a57a5a743894a0e4a801fc3', '1')"
        );

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE addresses DROP FOREIGN KEY FK_6FCA7516E7A1254A');
        $this->addSql('ALTER TABLE contacts DROP FOREIGN KEY FK_33401573A76ED395');
        $this->addSql('DROP TABLE contacts');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE addresses');
    }
}
