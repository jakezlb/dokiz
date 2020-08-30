<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200827125312 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE car_ride ADD start_postal_code VARCHAR(255) NOT NULL, ADD start_city VARCHAR(255) NOT NULL, ADD start_address VARCHAR(255) NOT NULL, ADD end_postal_code VARCHAR(255) NOT NULL, ADD end_city VARCHAR(255) NOT NULL, ADD end_address VARCHAR(255) NOT NULL, CHANGE reservation_id reservation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE job_id job_id INT DEFAULT NULL, CHANGE society_id society_id INT DEFAULT NULL, CHANGE roles roles JSON NOT NULL, CHANGE updated_at updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE car ADD start_reservation_date DATETIME NOT NULL, ADD end_reservation_date DATETIME NOT NULL, CHANGE society_id society_id INT DEFAULT NULL, CHANGE name name VARCHAR(20) DEFAULT NULL, CHANGE fuel fuel VARCHAR(200) DEFAULT NULL');
        $this->addSql('ALTER TABLE key_car CHANGE car_id car_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C849558702F506');
        $this->addSql('DROP INDEX IDX_42C849558702F506 ON reservation');
        $this->addSql('ALTER TABLE reservation ADD user_id INT DEFAULT NULL, ADD car_id INT DEFAULT NULL, DROP cars_id, DROP status_key, DROP state_premise_depature, DROP state_premise_arrival');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955C3C6F69F FOREIGN KEY (car_id) REFERENCES car (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_42C84955A76ED395 ON reservation (user_id)');
        $this->addSql('CREATE INDEX IDX_42C84955C3C6F69F ON reservation (car_id)');
        $this->addSql('ALTER TABLE society CHANGE postal_code postal_code INT DEFAULT NULL, CHANGE email_interlocutor email_interlocutor VARCHAR(255) DEFAULT NULL, CHANGE tel_interlocutor tel_interlocutor VARCHAR(10) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE car DROP start_reservation_date, DROP end_reservation_date, CHANGE society_id society_id INT DEFAULT NULL, CHANGE name name VARCHAR(20) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE fuel fuel VARCHAR(200) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE car_ride ADD start_address VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD end_address VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD km_number INT NOT NULL, ADD start_postal_code VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD start_city VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD end_postal_code VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD end_city VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP start_postal_code, DROP start_city, DROP start_address, DROP end_postal_code, DROP end_city, DROP end_adddress, CHANGE reservation_id reservation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE key_car CHANGE car_id car_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955A76ED395');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955C3C6F69F');
        $this->addSql('DROP INDEX UNIQ_42C84955A76ED395 ON reservation');
        $this->addSql('DROP INDEX IDX_42C84955C3C6F69F ON reservation');
        $this->addSql('ALTER TABLE reservation ADD cars_id INT DEFAULT NULL, ADD status_key VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD state_premise_depature DATETIME NOT NULL, ADD state_premise_arrival DATETIME NOT NULL, DROP user_id, DROP car_id');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C849558702F506 FOREIGN KEY (cars_id) REFERENCES car (id)');
        $this->addSql('CREATE INDEX IDX_42C849558702F506 ON reservation (cars_id)');
        $this->addSql('ALTER TABLE society CHANGE postal_code postal_code INT DEFAULT NULL, CHANGE email_interlocutor email_interlocutor VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE tel_interlocutor tel_interlocutor VARCHAR(10) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE user CHANGE job_id job_id INT DEFAULT NULL, CHANGE society_id society_id INT DEFAULT NULL, CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`, CHANGE updated_at updated_at DATETIME DEFAULT \'NULL\'');
    }
}
