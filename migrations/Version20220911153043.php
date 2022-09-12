<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220911153043 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP CONSTRAINT fk_d34a04ad376af9bb');
        $this->addSql('DROP INDEX idx_d34a04ad376af9bb');
        $this->addSql('ALTER TABLE product DROP in_check_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE product ADD in_check_id INT NOT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT fk_d34a04ad376af9bb FOREIGN KEY (in_check_id) REFERENCES "check" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_d34a04ad376af9bb ON product (in_check_id)');
    }
}
