<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220624130821 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE newborns_adults (newborn_id INT NOT NULL, adult_id INT NOT NULL, INDEX IDX_1114A6D2B8A5CF29 (newborn_id), INDEX IDX_1114A6D27CEA3A6D (adult_id), PRIMARY KEY(newborn_id, adult_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE newborns_adults ADD CONSTRAINT FK_1114A6D2B8A5CF29 FOREIGN KEY (newborn_id) REFERENCES newborn (id)');
        $this->addSql('ALTER TABLE newborns_adults ADD CONSTRAINT FK_1114A6D27CEA3A6D FOREIGN KEY (adult_id) REFERENCES adult (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE newborns_adults');
    }
}
