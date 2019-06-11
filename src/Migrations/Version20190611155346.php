<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190611155346 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON user (username)');
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

        $this->addSql('DROP TABLE user');
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
