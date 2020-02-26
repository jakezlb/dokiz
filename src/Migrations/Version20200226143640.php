<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200226143640 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE car ADD society_id INT DEFAULT NULL, CHANGE fuel fuel VARCHAR(20) DEFAULT NULL');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69DE6389D24 FOREIGN KEY (society_id) REFERENCES society (id)');
        $this->addSql('CREATE INDEX IDX_773DE69DE6389D24 ON car (society_id)');
        $this->addSql('ALTER TABLE car_ride ADD reservation_id INT DEFAULT NULL, CHANGE id_status id_status VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE car_ride ADD CONSTRAINT FK_5057687CB83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id)');
        $this->addSql('CREATE INDEX IDX_5057687CB83297E7 ON car_ride (reservation_id)');
        $this->addSql('ALTER TABLE society CHANGE postal_code postal_code INT DEFAULT NULL, CHANGE email_interlocutor email_interlocutor VARCHAR(255) DEFAULT NULL, CHANGE tel_interlocutor tel_interlocutor VARCHAR(10) DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD job_id INT DEFAULT NULL, ADD society_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649BE04EA9 FOREIGN KEY (job_id) REFERENCES job (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649E6389D24 FOREIGN KEY (society_id) REFERENCES society (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649BE04EA9 ON user (job_id)');
        $this->addSql('CREATE INDEX IDX_8D93D649E6389D24 ON user (society_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69DE6389D24');
        $this->addSql('DROP INDEX IDX_773DE69DE6389D24 ON car');
        $this->addSql('ALTER TABLE car DROP society_id, CHANGE fuel fuel VARCHAR(20) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE car_ride DROP FOREIGN KEY FK_5057687CB83297E7');
        $this->addSql('DROP INDEX IDX_5057687CB83297E7 ON car_ride');
        $this->addSql('ALTER TABLE car_ride DROP reservation_id, CHANGE id_status id_status VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE society CHANGE postal_code postal_code INT DEFAULT NULL, CHANGE email_interlocutor email_interlocutor VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE tel_interlocutor tel_interlocutor VARCHAR(10) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649BE04EA9');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649E6389D24');
        $this->addSql('DROP INDEX IDX_8D93D649BE04EA9 ON user');
        $this->addSql('DROP INDEX IDX_8D93D649E6389D24 ON user');
        $this->addSql('ALTER TABLE user DROP job_id, DROP society_id');
    }
}
