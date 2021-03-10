<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210310010627 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trainee ADD age INT NOT NULL, ADD sex VARCHAR(10) NOT NULL, ADD status VARCHAR(255) NOT NULL, ADD politics VARCHAR(255) NOT NULL, ADD area VARCHAR(255) DEFAULT NULL, ADD phone VARCHAR(15) DEFAULT NULL, ADD idnum VARCHAR(18) NOT NULL, ADD address VARCHAR(50) DEFAULT NULL, ADD skill VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trainee DROP age, DROP sex, DROP status, DROP politics, DROP area, DROP phone, DROP idnum, DROP address, DROP skill');
    }
}
