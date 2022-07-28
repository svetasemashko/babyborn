<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220728122208 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            'ALTER TABLE newborns_adults DROP FOREIGN KEY FK_1114A6D27CEA3A6D'
        );
        $this->addSql(
            'ALTER TABLE infant DROP FOREIGN KEY FK_4375CCD9B8A5CF29'
        );
        $this->addSql(
            'ALTER TABLE newborns_adults DROP FOREIGN KEY FK_1114A6D2B8A5CF29'
        );
        $this->addSql(
            'CREATE TABLE adults (id INT AUTO_INCREMENT NOT NULL, kid_id INT DEFAULT NULL,
                name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, INDEX IDX_81AB524F6A973770 (kid_id),
                PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB'
        );
        $this->addSql(
            'CREATE TABLE kids (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(200) NOT NULL,
                date_of_birth DATETIME NOT NULL, sex VARCHAR(100) NOT NULL, discr VARCHAR(255) NOT NULL,
                PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB'
        );
        $this->addSql(
            'ALTER TABLE adults ADD CONSTRAINT FK_81AB524F6A973770 FOREIGN KEY (kid_id) REFERENCES kids (id)'
        );
        $this->addSql(
            'DROP TABLE adult'
        );
        $this->addSql(
            'DROP TABLE infant'
        );
        $this->addSql(
            'DROP TABLE newborn'
        );
        $this->addSql(
            'DROP TABLE newborns_adults'
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql(
            'ALTER TABLE adults DROP FOREIGN KEY FK_81AB524F6A973770'
        );
        $this->addSql(
            'CREATE TABLE adult (id INT AUTO_INCREMENT NOT NULL,
                name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`,
                surname VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`,
                PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
                COMMENT = \'\' '
        );
        $this->addSql(
            'CREATE TABLE infant (id INT AUTO_INCREMENT NOT NULL, newborn_id INT DEFAULT NULL,
                name VARCHAR(200) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`,
                date_of_birth DATETIME NOT NULL, sex VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL
                COLLATE `utf8mb4_unicode_ci`, UNIQUE INDEX UNIQ_4375CCD9B8A5CF29 (newborn_id), PRIMARY KEY(id))
                DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' '
        );
        $this->addSql(
            'CREATE TABLE newborn (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(200) CHARACTER SET utf8mb4 NOT NULL
                COLLATE `utf8mb4_unicode_ci`, date_of_birth DATETIME NOT NULL, sex VARCHAR(100) CHARACTER SET utf8mb4
                NOT NULL COLLATE `utf8mb4_unicode_ci`, discr VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL
                COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4
                COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' '
        );
        $this->addSql(
            'CREATE TABLE newborns_adults (newborn_id INT NOT NULL, adult_id INT NOT NULL,
                INDEX IDX_1114A6D27CEA3A6D (adult_id), INDEX IDX_1114A6D2B8A5CF29 (newborn_id),
                PRIMARY KEY(newborn_id, adult_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`
                ENGINE = InnoDB COMMENT = \'\' '
        );
        $this->addSql(
            'ALTER TABLE infant ADD CONSTRAINT FK_4375CCD9B8A5CF29 FOREIGN KEY (newborn_id) REFERENCES newborn (id)
                ON UPDATE NO ACTION ON DELETE NO ACTION'
        );
        $this->addSql(
            'ALTER TABLE newborns_adults ADD CONSTRAINT FK_1114A6D27CEA3A6D FOREIGN KEY (adult_id)
                REFERENCES adult (id) ON UPDATE NO ACTION ON DELETE NO ACTION'
        );
        $this->addSql(
            'ALTER TABLE newborns_adults ADD CONSTRAINT FK_1114A6D2B8A5CF29 FOREIGN KEY (newborn_id)
                REFERENCES newborn (id) ON UPDATE NO ACTION ON DELETE NO ACTION'
        );
        $this->addSql(
            'DROP TABLE adults'
        );
        $this->addSql(
            'DROP TABLE kids'
        );
    }
}
