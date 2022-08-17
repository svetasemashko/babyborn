<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220816114930 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            'ALTER TABLE kid_states ADD kid_id INT DEFAULT NULL'
        );
        $this->addSql(
            'ALTER TABLE kid_states ADD CONSTRAINT FK_3B7141FF6A973770 FOREIGN KEY (kid_id) REFERENCES kids (id)'
        );
        $this->addSql(
            'CREATE INDEX IDX_3B7141FF6A973770 ON kid_states (kid_id)'
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql(
            'ALTER TABLE kid_states DROP FOREIGN KEY FK_3B7141FF6A973770'
        );
        $this->addSql(
            'DROP INDEX IDX_3B7141FF6A973770 ON kid_states'
        );
        $this->addSql(
            'ALTER TABLE kid_states DROP kid_id'
        );
    }
}
