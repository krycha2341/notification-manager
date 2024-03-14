<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240314230357 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE email (id INT NOT NULL, notification_id INT DEFAULT NULL, email VARCHAR(255) NOT NULL, status VARCHAR(35) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E7927C74EF1A9D84 ON email (notification_id)');
        $this->addSql('CREATE TABLE notification (id INT NOT NULL, user_id INT NOT NULL, title VARCHAR(255) NOT NULL, body TEXT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE push (id INT NOT NULL, notification_id INT DEFAULT NULL, token VARCHAR(255) NOT NULL, status VARCHAR(35) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5F3A1664EF1A9D84 ON push (notification_id)');
        $this->addSql('CREATE TABLE sms (id INT NOT NULL, notification_id INT DEFAULT NULL, phone_number VARCHAR(255) NOT NULL, status VARCHAR(35) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B0A93A77EF1A9D84 ON sms (notification_id)');
        $this->addSql('ALTER TABLE email ADD CONSTRAINT FK_E7927C74EF1A9D84 FOREIGN KEY (notification_id) REFERENCES notification (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE push ADD CONSTRAINT FK_5F3A1664EF1A9D84 FOREIGN KEY (notification_id) REFERENCES notification (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE sms ADD CONSTRAINT FK_B0A93A77EF1A9D84 FOREIGN KEY (notification_id) REFERENCES notification (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE email DROP CONSTRAINT FK_E7927C74EF1A9D84');
        $this->addSql('ALTER TABLE push DROP CONSTRAINT FK_5F3A1664EF1A9D84');
        $this->addSql('ALTER TABLE sms DROP CONSTRAINT FK_B0A93A77EF1A9D84');
        $this->addSql('DROP TABLE email');
        $this->addSql('DROP TABLE notification');
        $this->addSql('DROP TABLE push');
        $this->addSql('DROP TABLE sms');
    }
}
