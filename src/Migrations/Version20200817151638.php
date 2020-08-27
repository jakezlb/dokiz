<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200817151638 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE car CHANGE society_id society_id INT DEFAULT NULL, CHANGE name name VARCHAR(20) DEFAULT NULL, CHANGE fuel fuel VARCHAR(200) DEFAULT NULL');
        $this->addSql('ALTER TABLE car_ride CHANGE reservation_id reservation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE key_car CHANGE car_id car_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reservation CHANGE cars_id cars_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE society CHANGE postal_code postal_code INT DEFAULT NULL, CHANGE email_interlocutor email_interlocutor VARCHAR(255) DEFAULT NULL, CHANGE tel_interlocutor tel_interlocutor VARCHAR(10) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE job_id job_id INT DEFAULT NULL, CHANGE society_id society_id INT DEFAULT NULL, CHANGE roles roles JSON NOT NULL, CHANGE updated_at updated_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE car CHANGE society_id society_id INT DEFAULT NULL, CHANGE name name VARCHAR(20) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE fuel fuel VARCHAR(200) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE car_ride CHANGE reservation_id reservation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE key_car CHANGE car_id car_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reservation CHANGE cars_id cars_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE society CHANGE postal_code postal_code INT DEFAULT NULL, CHANGE email_interlocutor email_interlocutor VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE tel_interlocutor tel_interlocutor VARCHAR(10) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE user CHANGE job_id job_id INT DEFAULT NULL, CHANGE society_id society_id INT DEFAULT NULL, CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`, CHANGE updated_at updated_at DATETIME DEFAULT \'NULL\'');
    }
}
