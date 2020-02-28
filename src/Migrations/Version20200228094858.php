<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200228094858 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE passenger (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, car_ride_id INT NOT NULL, is_driver TINYINT(1) NOT NULL, INDEX IDX_3BEFE8DDA76ED395 (user_id), INDEX IDX_3BEFE8DD638171AC (car_ride_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE passenger ADD CONSTRAINT FK_3BEFE8DDA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE passenger ADD CONSTRAINT FK_3BEFE8DD638171AC FOREIGN KEY (car_ride_id) REFERENCES car_ride (id)');
        $this->addSql('ALTER TABLE car CHANGE society_id society_id INT DEFAULT NULL, CHANGE fuel fuel VARCHAR(20) DEFAULT NULL');
        $this->addSql('ALTER TABLE car_ride CHANGE reservation_id reservation_id INT DEFAULT NULL, CHANGE id_status id_status VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE society CHANGE postal_code postal_code INT DEFAULT NULL, CHANGE email_interlocutor email_interlocutor VARCHAR(255) DEFAULT NULL, CHANGE tel_interlocutor tel_interlocutor VARCHAR(10) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE job_id job_id INT DEFAULT NULL, CHANGE society_id society_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE passenger');
        $this->addSql('ALTER TABLE car CHANGE society_id society_id INT DEFAULT NULL, CHANGE fuel fuel VARCHAR(20) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE car_ride CHANGE reservation_id reservation_id INT DEFAULT NULL, CHANGE id_status id_status VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE society CHANGE postal_code postal_code INT DEFAULT NULL, CHANGE email_interlocutor email_interlocutor VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE tel_interlocutor tel_interlocutor VARCHAR(10) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE user CHANGE job_id job_id INT DEFAULT NULL, CHANGE society_id society_id INT DEFAULT NULL');
    }
}
