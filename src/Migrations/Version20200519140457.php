<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200519140457 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE car_ride ADD postal_code_point_departure VARCHAR(255) NOT NULL, ADD city_point_departure VARCHAR(255) NOT NULL, ADD postal_code_point_arrival VARCHAR(255) NOT NULL, ADD city_point_arrival VARCHAR(255) NOT NULL, DROP departure, DROP arrival, CHANGE reservation_id reservation_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE car_ride ADD departure VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD arrival VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP postal_code_point_departure, DROP city_point_departure, DROP postal_code_point_arrival, DROP city_point_arrival, CHANGE reservation_id reservation_id INT DEFAULT NULL');
    }
}
