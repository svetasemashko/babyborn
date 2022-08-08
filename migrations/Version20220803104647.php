<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220803104647 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            'CREATE TABLE kid_states (id INT AUTO_INCREMENT NOT NULL, kid_id INT DEFAULT NULL,
                discr VARCHAR(255) NOT NULL, INDEX IDX_3B7141FF6A973770 (kid_id), PRIMARY KEY(id)) DEFAULT CHARACTER
                SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB'
        );
        $this->addSql(
            'ALTER TABLE kid_states ADD CONSTRAINT FK_3B7141FF6A973770 FOREIGN KEY (kid_id) REFERENCES kids (id)'
        );
        $this->addSql(
            'ALTER TABLE kids DROP discr, DROP active'
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql(
            'DROP TABLE kid_states'
        );
        $this->addSql(
            'ALTER TABLE kids ADD discr VARCHAR(255) NOT NULL, ADD active TINYINT(1) NOT NULL'
        );
    }
}
