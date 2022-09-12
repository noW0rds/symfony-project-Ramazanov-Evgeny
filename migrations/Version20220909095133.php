<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220909095133 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE "check" ADD who_author_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE "check" ADD CONSTRAINT FK_3C8EAC137DE27E26 FOREIGN KEY (who_author_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_3C8EAC137DE27E26 ON "check" (who_author_id)');
        $this->addSql('ALTER TABLE guest ADD who_author_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE guest ADD CONSTRAINT FK_ACB79A357DE27E26 FOREIGN KEY (who_author_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_ACB79A357DE27E26 ON guest (who_author_id)');
        $this->addSql('ALTER TABLE party ADD who_author_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE party ADD CONSTRAINT FK_89954EE07DE27E26 FOREIGN KEY (who_author_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_89954EE07DE27E26 ON party (who_author_id)');
        $this->addSql('ALTER TABLE payment ADD who_author_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840D7DE27E26 FOREIGN KEY (who_author_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_6D28840D7DE27E26 ON payment (who_author_id)');
        $this->addSql('ALTER TABLE personal_check ADD who_author_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE personal_check ADD CONSTRAINT FK_64D7EA057DE27E26 FOREIGN KEY (who_author_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_64D7EA057DE27E26 ON personal_check (who_author_id)');
        $this->addSql('ALTER TABLE product ADD who_author_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD7DE27E26 FOREIGN KEY (who_author_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_D34A04AD7DE27E26 ON product (who_author_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE party DROP CONSTRAINT FK_89954EE07DE27E26');
        $this->addSql('DROP INDEX IDX_89954EE07DE27E26');
        $this->addSql('ALTER TABLE party DROP who_author_id');
        $this->addSql('ALTER TABLE guest DROP CONSTRAINT FK_ACB79A357DE27E26');
        $this->addSql('DROP INDEX IDX_ACB79A357DE27E26');
        $this->addSql('ALTER TABLE guest DROP who_author_id');
        $this->addSql('ALTER TABLE "check" DROP CONSTRAINT FK_3C8EAC137DE27E26');
        $this->addSql('DROP INDEX IDX_3C8EAC137DE27E26');
        $this->addSql('ALTER TABLE "check" DROP who_author_id');
        $this->addSql('ALTER TABLE product DROP CONSTRAINT FK_D34A04AD7DE27E26');
        $this->addSql('DROP INDEX IDX_D34A04AD7DE27E26');
        $this->addSql('ALTER TABLE product DROP who_author_id');
        $this->addSql('ALTER TABLE payment DROP CONSTRAINT FK_6D28840D7DE27E26');
        $this->addSql('DROP INDEX IDX_6D28840D7DE27E26');
        $this->addSql('ALTER TABLE payment DROP who_author_id');
        $this->addSql('ALTER TABLE personal_check DROP CONSTRAINT FK_64D7EA057DE27E26');
        $this->addSql('DROP INDEX IDX_64D7EA057DE27E26');
        $this->addSql('ALTER TABLE personal_check DROP who_author_id');
    }
}
