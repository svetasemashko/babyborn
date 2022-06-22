<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220603142415 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            'CREATE TABLE adult (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL,
                surname VARCHAR(255) NOT NULL, PRIMARY KEY(id))
                DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB'
        );
        $this->addSql(
            'CREATE TABLE adult_newborn (adult_id INT NOT NULL, newborn_id INT NOT NULL,
                INDEX IDX_3F470AE27CEA3A6D (adult_id), INDEX IDX_3F470AE2B8A5CF29 (newborn_id),
                PRIMARY KEY(adult_id, newborn_id)) 
                DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB'
        );
        $this->addSql(
            'CREATE TABLE newborns_adults (newborn_id INT NOT NULL, adult_id INT NOT NULL, 
                INDEX IDX_1114A6D2B8A5CF29 (newborn_id), INDEX IDX_1114A6D27CEA3A6D (adult_id),
                PRIMARY KEY(newborn_id, adult_id))
                DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB'
        );
        $this->addSql(
            'ALTER TABLE adult_newborn ADD CONSTRAINT FK_3F470AE27CEA3A6D FOREIGN KEY (adult_id)
                REFERENCES adult (id) ON DELETE CASCADE'
        );
        $this->addSql(
            'ALTER TABLE adult_newborn ADD CONSTRAINT FK_3F470AE2B8A5CF29 FOREIGN KEY (newborn_id)
                REFERENCES newborn (id) ON DELETE CASCADE'
        );
        $this->addSql(
            'ALTER TABLE newborns_adults ADD CONSTRAINT FK_1114A6D2B8A5CF29 FOREIGN KEY (newborn_id)
                REFERENCES newborn (id)'
        );
        $this->addSql(
            'ALTER TABLE newborns_adults ADD CONSTRAINT FK_1114A6D27CEA3A6D FOREIGN KEY (adult_id)
                REFERENCES adult (id)'
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE adult_newborn DROP FOREIGN KEY FK_3F470AE27CEA3A6D');
        $this->addSql('ALTER TABLE newborns_adults DROP FOREIGN KEY FK_1114A6D27CEA3A6D');
        $this->addSql('DROP TABLE adult');
        $this->addSql('DROP TABLE adult_newborn');
        $this->addSql('DROP TABLE newborns_adults');
    }
}
