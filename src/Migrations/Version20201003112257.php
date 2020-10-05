<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201003112257 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sent_email ADD society_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sent_email ADD CONSTRAINT FK_E92EE5FCE6389D24 FOREIGN KEY (society_id) REFERENCES society (id)');
        $this->addSql('CREATE INDEX IDX_E92EE5FCE6389D24 ON sent_email (society_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');       
        $this->addSql('ALTER TABLE sent_email DROP FOREIGN KEY FK_E92EE5FCE6389D24');
        $this->addSql('DROP INDEX IDX_E92EE5FCE6389D24 ON sent_email');
        $this->addSql('ALTER TABLE sent_email DROP society_id');
        
    }
}
