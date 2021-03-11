<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210311041358 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE trainee_training (trainee_id INT NOT NULL, training_id INT NOT NULL, INDEX IDX_1B77F00636C682D0 (trainee_id), INDEX IDX_1B77F006BEFD98D1 (training_id), PRIMARY KEY(trainee_id, training_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE trainee_training ADD CONSTRAINT FK_1B77F00636C682D0 FOREIGN KEY (trainee_id) REFERENCES trainee (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE trainee_training ADD CONSTRAINT FK_1B77F006BEFD98D1 FOREIGN KEY (training_id) REFERENCES training (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE trainee_training');
    }
}
