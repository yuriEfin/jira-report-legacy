<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210423210449 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE report_by_date ADD priority_count_blocker INT NOT NULL, ADD priority_count_medium INT NOT NULL, ADD priority_count_low INT NOT NULL, ADD priority_count_lowest INT NOT NULL, DROP priority_count_progress, DROP priority_count_block, DROP priority_count_bug, DROP priority_count_pause');
        $this->addSql('ALTER TABLE user CHANGE department_id department_id INT DEFAULT 6');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE report_by_date ADD priority_count_progress INT NOT NULL, ADD priority_count_block INT NOT NULL, ADD priority_count_bug INT NOT NULL, ADD priority_count_pause INT NOT NULL, DROP priority_count_blocker, DROP priority_count_medium, DROP priority_count_low, DROP priority_count_lowest');
        $this->addSql('ALTER TABLE user CHANGE department_id department_id INT DEFAULT 6');
    }
}
