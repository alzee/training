<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211018043019 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trainee ADD level VARCHAR(255) DEFAULT NULL, ADD edu VARCHAR(255) DEFAULT NULL, ADD company VARCHAR(255) DEFAULT NULL, ADD company_property VARCHAR(255) DEFAULT NULL, ADD service VARCHAR(255) DEFAULT NULL, ADD pro_local VARCHAR(255) DEFAULT NULL, ADD military_pro VARCHAR(255) DEFAULT NULL, ADD hometown VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trainee DROP level, DROP edu, DROP company, DROP company_property, DROP service, DROP pro_local, DROP military_pro, DROP hometown');
    }
}
