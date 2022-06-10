<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220610124749 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, total_kilometre DOUBLE PRECISION DEFAULT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, groupe INTEGER DEFAULT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON user (username)');
        $this->addSql('DROP INDEX IDX_2B5BA98CFD7FAAB7');
        $this->addSql('DROP INDEX IDX_2B5BA98CA76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__trajet AS SELECT id, lieu_tp_id, user_id, conducteur, date, commentaire, kilometrage FROM trajet');
        $this->addSql('DROP TABLE trajet');
        $this->addSql('CREATE TABLE trajet (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, lieu_tp_id INTEGER DEFAULT NULL, user_id INTEGER DEFAULT NULL, conducteur VARCHAR(255) DEFAULT NULL, date DATETIME NOT NULL, commentaire CLOB DEFAULT NULL, kilometrage DOUBLE PRECISION DEFAULT NULL, CONSTRAINT FK_2B5BA98CFD7FAAB7 FOREIGN KEY (lieu_tp_id) REFERENCES lieu_tp (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_2B5BA98CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO trajet (id, lieu_tp_id, user_id, conducteur, date, commentaire, kilometrage) SELECT id, lieu_tp_id, user_id, conducteur, date, commentaire, kilometrage FROM __temp__trajet');
        $this->addSql('DROP TABLE __temp__trajet');
        $this->addSql('CREATE INDEX IDX_2B5BA98CFD7FAAB7 ON trajet (lieu_tp_id)');
        $this->addSql('CREATE INDEX IDX_2B5BA98CA76ED395 ON trajet (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP INDEX IDX_2B5BA98CFD7FAAB7');
        $this->addSql('DROP INDEX IDX_2B5BA98CA76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__trajet AS SELECT id, lieu_tp_id, user_id, conducteur, date, commentaire, kilometrage FROM trajet');
        $this->addSql('DROP TABLE trajet');
        $this->addSql('CREATE TABLE trajet (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER DEFAULT NULL, lieu_tp_id INTEGER DEFAULT NULL, conducteur VARCHAR(255) DEFAULT NULL, date DATETIME NOT NULL, commentaire CLOB DEFAULT NULL, kilometrage DOUBLE PRECISION DEFAULT NULL, CONSTRAINT FK_2B5BA98CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO trajet (id, lieu_tp_id, user_id, conducteur, date, commentaire, kilometrage) SELECT id, lieu_tp_id, user_id, conducteur, date, commentaire, kilometrage FROM __temp__trajet');
        $this->addSql('DROP TABLE __temp__trajet');
        $this->addSql('CREATE INDEX IDX_2B5BA98CFD7FAAB7 ON trajet (lieu_tp_id)');
        $this->addSql('CREATE INDEX IDX_2B5BA98CA76ED395 ON trajet (user_id)');
    }
}
