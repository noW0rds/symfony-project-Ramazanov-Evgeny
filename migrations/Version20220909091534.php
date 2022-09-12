<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220909091534 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE "check_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE guest_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE party_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE payment_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE personal_check_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE product_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE "check" (id INT NOT NULL, buying_guest_id INT NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, store VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3C8EAC13B8275FE9 ON "check" (buying_guest_id)');
        $this->addSql('CREATE TABLE guest (id INT NOT NULL, who_user_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, number VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_ACB79A354B7011EC ON guest (who_user_id)');
        $this->addSql('CREATE TABLE guest_product (guest_id INT NOT NULL, product_id INT NOT NULL, PRIMARY KEY(guest_id, product_id))');
        $this->addSql('CREATE INDEX IDX_938FC0E19A4AA658 ON guest_product (guest_id)');
        $this->addSql('CREATE INDEX IDX_938FC0E14584665A ON guest_product (product_id)');
        $this->addSql('CREATE TABLE party (id INT NOT NULL, name VARCHAR(255) DEFAULT NULL, date_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, location VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN party.date_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE payment (id INT NOT NULL, from_guest_id INT DEFAULT NULL, to_guest_id INT NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, cost DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6D28840DDCA546C2 ON payment (from_guest_id)');
        $this->addSql('CREATE INDEX IDX_6D28840D571338F6 ON payment (to_guest_id)');
        $this->addSql('CREATE TABLE personal_check (id INT NOT NULL, who_check_id INT NOT NULL, product_id INT NOT NULL, guest_id INT NOT NULL, amount INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_64D7EA0559A652BD ON personal_check (who_check_id)');
        $this->addSql('CREATE INDEX IDX_64D7EA054584665A ON personal_check (product_id)');
        $this->addSql('CREATE INDEX IDX_64D7EA059A4AA658 ON personal_check (guest_id)');
        $this->addSql('CREATE TABLE product (id INT NOT NULL, in_check_id INT NOT NULL, name VARCHAR(255) NOT NULL, price INT NOT NULL, amount DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D34A04AD376AF9BB ON product (in_check_id)');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('ALTER TABLE "check" ADD CONSTRAINT FK_3C8EAC13B8275FE9 FOREIGN KEY (buying_guest_id) REFERENCES guest (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE guest ADD CONSTRAINT FK_ACB79A354B7011EC FOREIGN KEY (who_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE guest_product ADD CONSTRAINT FK_938FC0E19A4AA658 FOREIGN KEY (guest_id) REFERENCES guest (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE guest_product ADD CONSTRAINT FK_938FC0E14584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840DDCA546C2 FOREIGN KEY (from_guest_id) REFERENCES guest (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840D571338F6 FOREIGN KEY (to_guest_id) REFERENCES guest (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE personal_check ADD CONSTRAINT FK_64D7EA0559A652BD FOREIGN KEY (who_check_id) REFERENCES "check" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE personal_check ADD CONSTRAINT FK_64D7EA054584665A FOREIGN KEY (product_id) REFERENCES product (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE personal_check ADD CONSTRAINT FK_64D7EA059A4AA658 FOREIGN KEY (guest_id) REFERENCES guest (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD376AF9BB FOREIGN KEY (in_check_id) REFERENCES "check" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE personal_check DROP CONSTRAINT FK_64D7EA0559A652BD');
        $this->addSql('ALTER TABLE product DROP CONSTRAINT FK_D34A04AD376AF9BB');
        $this->addSql('ALTER TABLE "check" DROP CONSTRAINT FK_3C8EAC13B8275FE9');
        $this->addSql('ALTER TABLE guest_product DROP CONSTRAINT FK_938FC0E19A4AA658');
        $this->addSql('ALTER TABLE payment DROP CONSTRAINT FK_6D28840DDCA546C2');
        $this->addSql('ALTER TABLE payment DROP CONSTRAINT FK_6D28840D571338F6');
        $this->addSql('ALTER TABLE personal_check DROP CONSTRAINT FK_64D7EA059A4AA658');
        $this->addSql('ALTER TABLE guest_product DROP CONSTRAINT FK_938FC0E14584665A');
        $this->addSql('ALTER TABLE personal_check DROP CONSTRAINT FK_64D7EA054584665A');
        $this->addSql('ALTER TABLE guest DROP CONSTRAINT FK_ACB79A354B7011EC');
        $this->addSql('DROP SEQUENCE "check_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE guest_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE party_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE payment_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE personal_check_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE product_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('DROP TABLE "check"');
        $this->addSql('DROP TABLE guest');
        $this->addSql('DROP TABLE guest_product');
        $this->addSql('DROP TABLE party');
        $this->addSql('DROP TABLE payment');
        $this->addSql('DROP TABLE personal_check');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE "user"');
    }
}
