<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190615174656 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_23A0E66F675F31B');
        $this->addSql('CREATE TEMPORARY TABLE __temp__article AS SELECT id, author_id, title, image, content, created_at, caption_image FROM article');
        $this->addSql('DROP TABLE article');
        $this->addSql('CREATE TABLE article (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL COLLATE BINARY, image VARCHAR(255) DEFAULT NULL COLLATE BINARY, content CLOB NOT NULL COLLATE BINARY, created_at DATETIME NOT NULL, caption_image VARCHAR(255) DEFAULT NULL COLLATE BINARY, CONSTRAINT FK_23A0E66F675F31B FOREIGN KEY (author_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO article (id, author_id, title, image, content, created_at, caption_image) SELECT id, author_id, title, image, content, created_at, caption_image FROM __temp__article');
        $this->addSql('DROP TABLE __temp__article');
        $this->addSql('CREATE INDEX IDX_23A0E66F675F31B ON article (author_id)');
        $this->addSql('DROP INDEX IDX_9474526C7294869C');
        $this->addSql('CREATE TEMPORARY TABLE __temp__comment AS SELECT id, article_id, author, content, created_at FROM comment');
        $this->addSql('DROP TABLE comment');
        $this->addSql('CREATE TABLE comment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, article_id INTEGER DEFAULT NULL, author VARCHAR(255) NOT NULL COLLATE BINARY, content CLOB NOT NULL COLLATE BINARY, created_at DATETIME NOT NULL, CONSTRAINT FK_9474526C7294869C FOREIGN KEY (article_id) REFERENCES article (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO comment (id, article_id, author, content, created_at) SELECT id, article_id, author, content, created_at FROM __temp__comment');
        $this->addSql('DROP TABLE __temp__comment');
        $this->addSql('CREATE INDEX IDX_9474526C7294869C ON comment (article_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__reference AS SELECT id, name, customer, mission, image, link, created_at FROM reference');
        $this->addSql('DROP TABLE reference');
        $this->addSql('CREATE TABLE reference (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY, customer VARCHAR(255) NOT NULL COLLATE BINARY, mission CLOB NOT NULL COLLATE BINARY, image VARCHAR(255) DEFAULT NULL COLLATE BINARY, link VARCHAR(255) DEFAULT NULL COLLATE BINARY, created_at DATETIME NOT NULL)');
        $this->addSql('INSERT INTO reference (id, name, customer, mission, image, link, created_at) SELECT id, name, customer, mission, image, link, created_at FROM __temp__reference');
        $this->addSql('DROP TABLE __temp__reference');
        $this->addSql('DROP INDEX IDX_BF9473341645DEA9');
        $this->addSql('DROP INDEX IDX_BF947334BAD26311');
        $this->addSql('CREATE TEMPORARY TABLE __temp__tag_reference AS SELECT tag_id, reference_id FROM tag_reference');
        $this->addSql('DROP TABLE tag_reference');
        $this->addSql('CREATE TABLE tag_reference (tag_id INTEGER NOT NULL, reference_id INTEGER NOT NULL, PRIMARY KEY(tag_id, reference_id), CONSTRAINT FK_BF947334BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_BF9473341645DEA9 FOREIGN KEY (reference_id) REFERENCES reference (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO tag_reference (tag_id, reference_id) SELECT tag_id, reference_id FROM __temp__tag_reference');
        $this->addSql('DROP TABLE __temp__tag_reference');
        $this->addSql('CREATE INDEX IDX_BF9473341645DEA9 ON tag_reference (reference_id)');
        $this->addSql('CREATE INDEX IDX_BF947334BAD26311 ON tag_reference (tag_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_23A0E66F675F31B');
        $this->addSql('CREATE TEMPORARY TABLE __temp__article AS SELECT id, author_id, title, image, caption_image, content, created_at FROM article');
        $this->addSql('DROP TABLE article');
        $this->addSql('CREATE TABLE article (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, caption_image VARCHAR(255) DEFAULT NULL, content CLOB NOT NULL, created_at DATETIME NOT NULL)');
        $this->addSql('INSERT INTO article (id, author_id, title, image, caption_image, content, created_at) SELECT id, author_id, title, image, caption_image, content, created_at FROM __temp__article');
        $this->addSql('DROP TABLE __temp__article');
        $this->addSql('CREATE INDEX IDX_23A0E66F675F31B ON article (author_id)');
        $this->addSql('DROP INDEX IDX_9474526C7294869C');
        $this->addSql('CREATE TEMPORARY TABLE __temp__comment AS SELECT id, article_id, author, content, created_at FROM comment');
        $this->addSql('DROP TABLE comment');
        $this->addSql('CREATE TABLE comment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, article_id INTEGER DEFAULT NULL, author VARCHAR(255) NOT NULL, content CLOB NOT NULL, created_at DATETIME NOT NULL)');
        $this->addSql('INSERT INTO comment (id, article_id, author, content, created_at) SELECT id, article_id, author, content, created_at FROM __temp__comment');
        $this->addSql('DROP TABLE __temp__comment');
        $this->addSql('CREATE INDEX IDX_9474526C7294869C ON comment (article_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__reference AS SELECT id, name, customer, mission, image, link, created_at FROM reference');
        $this->addSql('DROP TABLE reference');
        $this->addSql('CREATE TABLE reference (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, customer VARCHAR(255) NOT NULL, mission CLOB NOT NULL, image VARCHAR(255) DEFAULT NULL, link VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL)');
        $this->addSql('INSERT INTO reference (id, name, customer, mission, image, link, created_at) SELECT id, name, customer, mission, image, link, created_at FROM __temp__reference');
        $this->addSql('DROP TABLE __temp__reference');
        $this->addSql('DROP INDEX IDX_BF947334BAD26311');
        $this->addSql('DROP INDEX IDX_BF9473341645DEA9');
        $this->addSql('CREATE TEMPORARY TABLE __temp__tag_reference AS SELECT tag_id, reference_id FROM tag_reference');
        $this->addSql('DROP TABLE tag_reference');
        $this->addSql('CREATE TABLE tag_reference (tag_id INTEGER NOT NULL, reference_id INTEGER NOT NULL, PRIMARY KEY(tag_id, reference_id))');
        $this->addSql('INSERT INTO tag_reference (tag_id, reference_id) SELECT tag_id, reference_id FROM __temp__tag_reference');
        $this->addSql('DROP TABLE __temp__tag_reference');
        $this->addSql('CREATE INDEX IDX_BF947334BAD26311 ON tag_reference (tag_id)');
        $this->addSql('CREATE INDEX IDX_BF9473341645DEA9 ON tag_reference (reference_id)');
    }
}
