<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200302104111 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE key_car (id INT AUTO_INCREMENT NOT NULL, car_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_A334FB4DC3C6F69F (car_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE key_car ADD CONSTRAINT FK_A334FB4DC3C6F69F FOREIGN KEY (car_id) REFERENCES car (id)');
        $this->addSql('DROP TABLE key_box');
        $this->addSql('ALTER TABLE car ADD name VARCHAR(20) DEFAULT NULL, ADD mark VARCHAR(200) NOT NULL, CHANGE society_id society_id INT DEFAULT NULL, CHANGE fuel fuel VARCHAR(200) DEFAULT NULL');
        $this->addSql('ALTER TABLE car_ride CHANGE reservation_id reservation_id INT DEFAULT NULL, CHANGE id_status id_status VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE society CHANGE postal_code postal_code INT DEFAULT NULL, CHANGE email_interlocutor email_interlocutor VARCHAR(255) DEFAULT NULL, CHANGE tel_interlocutor tel_interlocutor VARCHAR(10) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE job_id job_id INT DEFAULT NULL, CHANGE society_id society_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE key_box (id INT AUTO_INCREMENT NOT NULL, adress_key_box VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE key_car');
        $this->addSql('ALTER TABLE car DROP name, DROP mark, CHANGE society_id society_id INT DEFAULT NULL, CHANGE fuel fuel VARCHAR(20) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE car_ride CHANGE reservation_id reservation_id INT DEFAULT NULL, CHANGE id_status id_status VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE society CHANGE postal_code postal_code INT DEFAULT NULL, CHANGE email_interlocutor email_interlocutor VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE tel_interlocutor tel_interlocutor VARCHAR(10) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE user CHANGE job_id job_id INT DEFAULT NULL, CHANGE society_id society_id INT DEFAULT NULL');
    }
}
