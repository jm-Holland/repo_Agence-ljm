<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190611154012 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TEMPORARY TABLE __temp__client AS SELECT id, first_name, last_name, email, organisation, adress, code_postal, city, country FROM client');
        $this->addSql('DROP TABLE client');
        $this->addSql('CREATE TABLE client (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL COLLATE BINARY, last_name VARCHAR(255) NOT NULL COLLATE BINARY, email VARCHAR(255) NOT NULL COLLATE BINARY, organisation VARCHAR(255) DEFAULT NULL COLLATE BINARY, adress VARCHAR(255) DEFAULT NULL COLLATE BINARY, city VARCHAR(255) DEFAULT NULL COLLATE BINARY, country VARCHAR(255) DEFAULT NULL COLLATE BINARY, code_postal VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO client (id, first_name, last_name, email, organisation, adress, code_postal, city, country) SELECT id, first_name, last_name, email, organisation, adress, code_postal, city, country FROM __temp__client');
        $this->addSql('DROP TABLE __temp__client');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TEMPORARY TABLE __temp__client AS SELECT id, first_name, last_name, email, organisation, adress, code_postal, city, country FROM client');
        $this->addSql('DROP TABLE client');
        $this->addSql('CREATE TABLE client (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, organisation VARCHAR(255) DEFAULT NULL, adress VARCHAR(255) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, country VARCHAR(255) DEFAULT NULL, code_postal INTEGER DEFAULT NULL)');
        $this->addSql('INSERT INTO client (id, first_name, last_name, email, organisation, adress, code_postal, city, country) SELECT id, first_name, last_name, email, organisation, adress, code_postal, city, country FROM __temp__client');
        $this->addSql('DROP TABLE __temp__client');
    }
}
