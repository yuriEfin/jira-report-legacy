<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210423192819 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE report_by_date ADD priority_count_progress INT NOT NULL, ADD priority_count_block INT NOT NULL, ADD priority_count_highest INT NOT NULL, ADD priority_count_high INT NOT NULL, ADD priority_count_bug INT NOT NULL, ADD priority_count_pause INT NOT NULL, ADD statuses_count_todo INT NOT NULL, ADD statuses_count_progress INT NOT NULL, ADD statuses_count_reopened INT NOT NULL, ADD statuses_count_review INT NOT NULL, ADD statuses_count_tests INT NOT NULL, ADD statuses_count_in_tests INT NOT NULL, ADD statuses_count_pause INT NOT NULL, DROP count_progress, DROP count_block, DROP count_highest, DROP count_high, DROP count_bug, DROP count_all, DROP count_pause');
        $this->addSql('ALTER TABLE user CHANGE department_id department_id INT DEFAULT 6');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE report_by_date ADD count_progress INT NOT NULL, ADD count_block INT NOT NULL, ADD count_highest INT NOT NULL, ADD count_high INT NOT NULL, ADD count_bug INT NOT NULL, ADD count_all INT NOT NULL, ADD count_pause INT NOT NULL, DROP priority_count_progress, DROP priority_count_block, DROP priority_count_highest, DROP priority_count_high, DROP priority_count_bug, DROP priority_count_pause, DROP statuses_count_todo, DROP statuses_count_progress, DROP statuses_count_reopened, DROP statuses_count_review, DROP statuses_count_tests, DROP statuses_count_in_tests, DROP statuses_count_pause');
        $this->addSql('ALTER TABLE user CHANGE department_id department_id INT DEFAULT 6');
    }
}
