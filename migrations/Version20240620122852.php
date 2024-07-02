<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240620122852 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE review_livre DROP FOREIGN KEY FK_BFED638237D925CB');
        $this->addSql('ALTER TABLE review_livre DROP FOREIGN KEY FK_BFED63823E2E969B');
        $this->addSql('DROP TABLE review_livre');
        $this->addSql('ALTER TABLE livre ADD review_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE livre ADD CONSTRAINT FK_AC634F993E2E969B FOREIGN KEY (review_id) REFERENCES review (id)');
        $this->addSql('CREATE INDEX IDX_AC634F993E2E969B ON livre (review_id)');
        $this->addSql('ALTER TABLE review DROP review_star');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE review_livre (review_id INT NOT NULL, livre_id INT NOT NULL, INDEX IDX_BFED63823E2E969B (review_id), INDEX IDX_BFED638237D925CB (livre_id), PRIMARY KEY(review_id, livre_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE review_livre ADD CONSTRAINT FK_BFED638237D925CB FOREIGN KEY (livre_id) REFERENCES livre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE review_livre ADD CONSTRAINT FK_BFED63823E2E969B FOREIGN KEY (review_id) REFERENCES review (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE livre DROP FOREIGN KEY FK_AC634F993E2E969B');
        $this->addSql('DROP INDEX IDX_AC634F993E2E969B ON livre');
        $this->addSql('ALTER TABLE livre DROP review_id');
        $this->addSql('ALTER TABLE review ADD review_star BIGINT NOT NULL');
    }
}
