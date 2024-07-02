<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240620115537 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE auteur DROP FOREIGN KEY FK_55AB14037D925CB');
        $this->addSql('DROP INDEX IDX_55AB14037D925CB ON auteur');
        $this->addSql('ALTER TABLE auteur DROP livre_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE auteur ADD livre_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE auteur ADD CONSTRAINT FK_55AB14037D925CB FOREIGN KEY (livre_id) REFERENCES livre (id)');
        $this->addSql('CREATE INDEX IDX_55AB14037D925CB ON auteur (livre_id)');
    }
}
