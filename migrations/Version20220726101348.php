<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220726101348 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            'ALTER TABLE infant DROP FOREIGN KEY FK_4375CCD9B8A5CF29'
        );
        $this->addSql(
            'DROP INDEX UNIQ_4375CCD9B8A5CF29 ON infant'
        );
        $this->addSql(
            'ALTER TABLE infant CHANGE newborn_id newborn INT DEFAULT NULL'
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql(
            'ALTER TABLE infant CHANGE newborn newborn_id INT DEFAULT NULL'
        );
        $this->addSql(
            'ALTER TABLE infant ADD CONSTRAINT FK_4375CCD9B8A5CF29 FOREIGN KEY (newborn_id)
                REFERENCES newborn (id) ON UPDATE NO ACTION ON DELETE NO ACTION'
        );
        $this->addSql(
            'CREATE UNIQUE INDEX UNIQ_4375CCD9B8A5CF29 ON infant (newborn_id)'
        );
    }
}
