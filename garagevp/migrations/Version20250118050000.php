<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250118050000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Combined migrations for services and users';
    }

    public function up(Schema $schema): void
    {
        // Modifications de information_garage
        $this->addSql('ALTER TABLE information_garage ALTER horaires TYPE VARCHAR(255)');

        // Modifications de service
        $this->addSql('ALTER TABLE service ALTER description TYPE TEXT');
        $this->addSql('ALTER TABLE service ALTER description DROP NOT NULL');
        $this->addSql('ALTER TABLE service ADD image_filename VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE service ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE service ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');

        // Modifications de users
        $this->addSql('ALTER TABLE users ADD last_login_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE users ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL');
        
        // Mise à jour des données existantes
        $this->addSql('UPDATE users SET created_at = CURRENT_TIMESTAMP WHERE created_at IS NULL');
        $this->addSql('UPDATE service SET created_at = CURRENT_TIMESTAMP WHERE created_at IS NULL');
    }

    public function down(Schema $schema): void
    {
        // Restauration de information_garage
        $this->addSql('ALTER TABLE information_garage ALTER horaires TYPE VARCHAR(255)');

        // Restauration de service
        $this->addSql('ALTER TABLE service ALTER description TYPE TEXT');
        $this->addSql('ALTER TABLE service ALTER description SET NOT NULL');
        $this->addSql('ALTER TABLE service DROP image_filename');
        $this->addSql('ALTER TABLE service DROP created_at');
        $this->addSql('ALTER TABLE service DROP updated_at');

        // Restauration de users
        $this->addSql('ALTER TABLE users DROP last_login_at');
        $this->addSql('ALTER TABLE users DROP created_at');
    }
}