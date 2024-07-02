<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240620121500 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE langue DROP FOREIGN KEY FK_9357758E37D925CB');
        $this->addSql('DROP INDEX IDX_9357758E37D925CB ON langue');
        $this->addSql('ALTER TABLE langue DROP livre_id');
        $this->addSql('ALTER TABLE livre ADD langue_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE livre ADD CONSTRAINT FK_AC634F992AADBACD FOREIGN KEY (langue_id) REFERENCES langue (id)');
        $this->addSql('CREATE INDEX IDX_AC634F992AADBACD ON livre (langue_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE langue ADD livre_id INT NOT NULL');
        $this->addSql('ALTER TABLE langue ADD CONSTRAINT FK_9357758E37D925CB FOREIGN KEY (livre_id) REFERENCES livre (id)');
        $this->addSql('CREATE INDEX IDX_9357758E37D925CB ON langue (livre_id)');
        $this->addSql('ALTER TABLE livre DROP FOREIGN KEY FK_AC634F992AADBACD');
        $this->addSql('DROP INDEX IDX_AC634F992AADBACD ON livre');
        $this->addSql('ALTER TABLE livre DROP langue_id');
    }
}
