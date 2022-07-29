<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220729095122 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            'ALTER TABLE kids CHANGE active active TINYINT(1) NOT NULL'
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql(
            'ALTER TABLE kids CHANGE active active TINYINT(1) DEFAULT 1 NOT NULL'
        );
    }
}
