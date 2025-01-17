<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250117204233 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE information_garage RENAME COLUMN horaires TO nom');
        $this->addSql('ALTER TABLE information_garage ALTER nom TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE service ALTER description TYPE TEXT');
        $this->addSql('ALTER TABLE service ALTER description SET NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE information_garage RENAME COLUMN nom TO horaires');
        $this->addSql('ALTER TABLE information_garage ALTER horaires TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE service ALTER description TYPE TEXT');
        $this->addSql('ALTER TABLE service ALTER description DROP NOT NULL');
    }
}
