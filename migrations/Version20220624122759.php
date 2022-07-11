<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220624122759 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            'DROP TABLE adult_newborn'
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql(
            'CREATE TABLE adult_newborn (adult_id INT NOT NULL, newborn_id INT NOT NULL,
                INDEX IDX_3F470AE27CEA3A6D (adult_id), INDEX IDX_3F470AE2B8A5CF29 (newborn_id),
                PRIMARY KEY(adult_id, newborn_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`
                ENGINE = InnoDB COMMENT = \'\' '
        );
        $this->addSql(
            'ALTER TABLE adult_newborn ADD CONSTRAINT FK_3F470AE27CEA3A6D FOREIGN KEY (adult_id)
                REFERENCES adult (id) ON UPDATE NO ACTION ON DELETE CASCADE'
        );
        $this->addSql(
            'ALTER TABLE adult_newborn ADD CONSTRAINT FK_3F470AE2B8A5CF29 FOREIGN KEY (newborn_id)
                REFERENCES newborn (id) ON UPDATE NO ACTION ON DELETE CASCADE'
        );
    }
}
