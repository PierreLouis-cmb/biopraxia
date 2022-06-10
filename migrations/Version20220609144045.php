<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220609144045 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_2B5BA98CA76ED395');
        $this->addSql('DROP INDEX IDX_2B5BA98CFD7FAAB7');
        $this->addSql('CREATE TEMPORARY TABLE __temp__trajet AS SELECT id, lieu_tp_id, user_id, conducteur FROM trajet');
        $this->addSql('DROP TABLE trajet');
        $this->addSql('CREATE TABLE trajet (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, lieu_tp_id INTEGER DEFAULT NULL, user_id INTEGER DEFAULT NULL, conducteur VARCHAR(255) DEFAULT NULL, date DATETIME NOT NULL, commentaire CLOB DEFAULT NULL, CONSTRAINT FK_2B5BA98CFD7FAAB7 FOREIGN KEY (lieu_tp_id) REFERENCES lieu_tp (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_2B5BA98CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO trajet (id, lieu_tp_id, user_id, conducteur) SELECT id, lieu_tp_id, user_id, conducteur FROM __temp__trajet');
        $this->addSql('DROP TABLE __temp__trajet');
        $this->addSql('CREATE INDEX IDX_2B5BA98CA76ED395 ON trajet (user_id)');
        $this->addSql('CREATE INDEX IDX_2B5BA98CFD7FAAB7 ON trajet (lieu_tp_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_2B5BA98CFD7FAAB7');
        $this->addSql('DROP INDEX IDX_2B5BA98CA76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__trajet AS SELECT id, lieu_tp_id, user_id, conducteur FROM trajet');
        $this->addSql('DROP TABLE trajet');
        $this->addSql('CREATE TABLE trajet (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, lieu_tp_id INTEGER DEFAULT NULL, user_id INTEGER DEFAULT NULL, conducteur VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO trajet (id, lieu_tp_id, user_id, conducteur) SELECT id, lieu_tp_id, user_id, conducteur FROM __temp__trajet');
        $this->addSql('DROP TABLE __temp__trajet');
        $this->addSql('CREATE INDEX IDX_2B5BA98CFD7FAAB7 ON trajet (lieu_tp_id)');
        $this->addSql('CREATE INDEX IDX_2B5BA98CA76ED395 ON trajet (user_id)');
    }
}
