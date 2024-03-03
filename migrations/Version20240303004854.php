<?php

declare(strict_types=1);

namespace migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240303004854 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE employee_company (employee_id INT NOT NULL, company_id INT NOT NULL, INDEX IDX_CFF35F408C03F15C (employee_id), INDEX IDX_CFF35F40979B1AD6 (company_id), PRIMARY KEY(employee_id, company_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE employee_company ADD CONSTRAINT FK_CFF35F408C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE employee_company ADD CONSTRAINT FK_CFF35F40979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE employee_company DROP FOREIGN KEY FK_CFF35F408C03F15C');
        $this->addSql('ALTER TABLE employee_company DROP FOREIGN KEY FK_CFF35F40979B1AD6');
        $this->addSql('DROP TABLE employee_company');
    }
}
