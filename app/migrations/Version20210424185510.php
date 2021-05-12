<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210424185510 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE report_by_date ADD type_count_bug INT NOT NULL, ADD type_count_feature INT NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE department_id department_id INT DEFAULT 6');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE report_by_date DROP type_count_bug, DROP type_count_feature');
        $this->addSql('ALTER TABLE user CHANGE department_id department_id INT DEFAULT 6');
    }
}
