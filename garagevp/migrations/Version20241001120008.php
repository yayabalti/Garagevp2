<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241001120008 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE administrateur (id_administrateur VARCHAR(250) NOT NULL, nom VARCHAR(250) NOT NULL, prenom VARCHAR(250) NOT NULL, email VARCHAR(50) NOT NULL, mot_de_passe VARCHAR(250) NOT NULL, date_connexion TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, role VARCHAR(50) NOT NULL, id_service_entretien VARCHAR(100) NOT NULL, id_services_carrosserie VARCHAR(250) NOT NULL, id_mecanique VARCHAR(250) NOT NULL, id_horaire_garage VARCHAR(200) NOT NULL, id_info_garage VARCHAR(100) NOT NULL, PRIMARY KEY(id_administrateur)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_32EB52E8E7927C74 ON administrateur (email)');
        $this->addSql('CREATE TABLE avis (id_avis VARCHAR(200) NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, commentaire TEXT NOT NULL, note NUMERIC(1, 0) NOT NULL, date_avis TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id_avis))');
        $this->addSql('CREATE TABLE employe (id_employe VARCHAR(250) NOT NULL, nom VARCHAR(250) NOT NULL, prenom VARCHAR(250) NOT NULL, email VARCHAR(250) NOT NULL, mot_de_passe VARCHAR(250) NOT NULL, date_connexion TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, role VARCHAR(50) NOT NULL, id_avis VARCHAR(200) NOT NULL, PRIMARY KEY(id_employe))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F804D3B9E7927C74 ON employe (email)');
        $this->addSql('CREATE TABLE horaire_garage (id_horaire_garage VARCHAR(200) NOT NULL, jour_de_semaine VARCHAR(15) NOT NULL, heure_douverture TIME(0) WITHOUT TIME ZONE NOT NULL, heure_de_fermeture TIME(0) WITHOUT TIME ZONE NOT NULL, fermeture_garage BOOLEAN NOT NULL, ID_Visiteur VARCHAR(250) DEFAULT NULL, PRIMARY KEY(id_horaire_garage)');
        $this->addSql('CREATE INDEX IDX_8E4282E02EC9857C ON horaire_garage (ID_Visiteur)');
        $this->addSql('CREATE TABLE info_garage (id_info_garage VARCHAR(100) NOT NULL, adresse VARCHAR(250) NOT NULL, ville VARCHAR(100) NOT NULL, code_postal VARCHAR(20) NOT NULL, pays VARCHAR(100) NOT NULL, numero_telephone VARCHAR(20) NOT NULL, email VARCHAR(100) NOT NULL, ID_Visiteur VARCHAR(250) DEFAULT NULL, PRIMARY KEY(id_info_garage)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_52FB3E5DE7927C74 ON info_garage (email)');
        $this->addSql('CREATE INDEX IDX_52FB3E5D2EC9857C ON info_garage (ID_Visiteur)');
        $this->addSql('CREATE TABLE service_carrosserie (id_services_carrosserie VARCHAR(250) NOT NULL, type_service VARCHAR(350) NOT NULL, description_travaux VARCHAR(450) NOT NULL, duree_estimee TIME(0) WITHOUT TIME ZONE NOT NULL, tarif NUMERIC(20, 2) NOT NULL, equipement_utilisee VARCHAR(300) NOT NULL, ID_Visiteur VARCHAR(250) DEFAULT NULL, PRIMARY KEY(id_services_carrosserie)');
        $this->addSql('CREATE INDEX IDX_FC7E52C32EC9857C ON service_carrosserie (ID_Visiteur)');
        $this->addSql('CREATE TABLE service_entretien (id_service_entretien VARCHAR(100) NOT NULL, type_service VARCHAR(200) NOT NULL, description_travaux VARCHAR(350) NOT NULL, duree_estimee TIME(0) WITHOUT TIME ZONE NOT NULL, tarif NUMERIC(5, 0) NOT NULL, equipement_utilisee VARCHAR(330) NOT NULL, ID_Visiteur VARCHAR(250) DEFAULT NULL, PRIMARY KEY(id_service_entretien)');
        $this->addSql('CREATE INDEX IDX_73C9EC902EC9857C ON service_entretien (ID_Visiteur)');
        $this->addSql('CREATE TABLE service_mecanique (id_mecanique VARCHAR(250) NOT NULL, type_service VARCHAR(350) NOT NULL, description_travaux VARCHAR(500) NOT NULL, duree_estimee TIME(0) WITHOUT TIME ZONE NOT NULL, tarif NUMERIC(20, 2) NOT NULL, equipement_utilisee VARCHAR(250) NOT NULL, ID_Visiteur VARCHAR(250) DEFAULT NULL, PRIMARY KEY(id_mecanique)');
        $this->addSql('CREATE INDEX IDX_A8C607E92EC9857C ON service_mecanique (ID_Visiteur)');
        $this->addSql('CREATE TABLE service_vente_voiture_occasion (id_voiture VARCHAR(200) NOT NULL, marque VARCHAR(50) NOT NULL, model VARCHAR(50) NOT NULL, annee_mise_en_circulation DATE NOT NULL, prix NUMERIC(25, 2) NOT NULL, kilometrage INT NOT NULL, description TEXT NOT NULL, image_principale VARCHAR(250) NOT NULL, galerie_images TEXT NOT NULL, caracteristiques TEXT NOT NULL, equipements TEXT NOT NULL, idVisiteur VARCHAR(250) DEFAULT NULL, idEmploye VARCHAR(250) DEFAULT NULL, PRIMARY KEY(id_voiture))');
        $this->addSql('CREATE INDEX IDX_91DD2A9D1D06ADE3 ON service_vente_voiture_occasion (idVisiteur)');
        $this->addSql('CREATE INDEX IDX_91DD2A9DE8BDB84B ON service_vente_voiture_occasion (idEmploye)');
        $this->addSql('CREATE TABLE utilisateur (id_user VARCHAR(100) NOT NULL, email VARCHAR(50) NOT NULL, mot_de_passe VARCHAR(150) NOT NULL, role_utilisateur VARCHAR(50) NOT NULL, date_et_heures_de_connexion TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, idAdministrateur VARCHAR(250) DEFAULT NULL, idEmploye VARCHAR(250) DEFAULT NULL, PRIMARY KEY(id_user)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1D1C63B3E7927C74 ON utilisateur (email)');
        $this->addSql('CREATE INDEX IDX_1D1C63B3EEF7BB7B ON utilisateur (idAdministrateur)');
        $this->addSql('CREATE INDEX IDX_1D1C63B3E8BDB84B ON utilisateur (idEmploye)');
        $this->addSql('CREATE TABLE visiteur (id_visiteur VARCHAR(250) NOT NULL, nom VARCHAR(250) NOT NULL, prenom VARCHAR(250) NOT NULL, date_connexion TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, ID_Avis VARCHAR(200) DEFAULT NULL, PRIMARY KEY(id_visiteur)');
        $this->addSql('CREATE INDEX IDX_4EA587B86C922466 ON visiteur (ID_Avis)');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id)');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E4F0038 ON messenger_messages (available_at)');
        
        // Ajout des contraintes de clé étrangère
        $this->addSql('ALTER TABLE horaire_garage ADD CONSTRAINT FK_8E4282E02EC9857C FOREIGN KEY (ID_Visiteur) REFERENCES visiteur (id_visiteur) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE info_garage ADD CONSTRAINT FK_52FB3E5D2EC9857C FOREIGN KEY (ID_Visiteur) REFERENCES visiteur (id_visiteur) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE service_carrosserie ADD CONSTRAINT FK_FC7E52C32EC9857C FOREIGN KEY (ID_Visiteur) REFERENCES visiteur (id_visiteur) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE service_entretien ADD CONSTRAINT FK_73C9EC902EC9857C FOREIGN KEY (ID_Visiteur) REFERENCES visiteur (id_visiteur) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE service_mecanique ADD CONSTRAINT FK_A8C607E92EC9857C FOREIGN KEY (ID_Visiteur) REFERENCES visiteur (id_visiteur) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE service_vente_voiture_occasion ADD CONSTRAINT FK_91DD2A9D1D06ADE3 FOREIGN KEY (idVisiteur) REFERENCES visiteur (id_visiteur) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3EEF7BB7B FOREIGN KEY (idAdministrateur) REFERENCES administrateur (id_administrateur) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3E8BDB84B FOREIGN KEY (idEmploye) REFERENCES employe (id_employe) ON DELETE SET NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur DROP CONSTRAINT FK_1D1C63B3E8BDB84B');
        $this->addSql('ALTER TABLE utilisateur DROP CONSTRAINT FK_1D1C63B3EEF7BB7B');
        $this->addSql('ALTER TABLE service_vente_voiture_occasion DROP CONSTRAINT FK_91DD2A9D1D06ADE3');
        $this->addSql('ALTER TABLE service_mecanique DROP CONSTRAINT FK_A8C607E92EC9857C');
        $this->addSql('ALTER TABLE service_entretien DROP CONSTRAINT FK_73C9EC902EC9857C');
        $this->addSql('ALTER TABLE service_carrosserie DROP CONSTRAINT FK_FC7E52C32EC9857C');
        $this->addSql('ALTER TABLE info_garage DROP CONSTRAINT FK_52FB3E5D2EC9857C');
        $this->addSql('ALTER TABLE horaire_garage DROP CONSTRAINT FK_8E4282E02EC9857C');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('DROP TABLE service_vente_voiture_occasion');
        $this->addSql('DROP TABLE service_mecanique');
        $this->addSql('DROP TABLE service_entretien');
        $this->addSql('DROP TABLE service_carrosserie');
        $this->addSql('DROP TABLE info_garage');
        $this->addSql('DROP TABLE horaire_garage');
        $this->addSql('DROP TABLE employe');
        $this->addSql('DROP TABLE avis');
        $this->addSql('DROP TABLE administrateur');
        $this->addSql('DROP TABLE visiteur');
        $this->addSql('DROP TABLE utilisateur');
    }
}


// declare(strict_types=1);

// namespace DoctrineMigrations;

// use Doctrine\DBAL\Schema\Schema;
// use Doctrine\Migrations\AbstractMigration;

// /**
//  * Auto-generated Migration: Please modify to your needs!
//  */
// final class Version20241001120008 extends AbstractMigration
// {
//     public function getDescription(): string
//     {
//         return '';
//     }

//     public function up(Schema $schema): void
//     {
//         // this up() migration is auto-generated, please modify it to your needs
//         $this->addSql('CREATE TABLE administrateur (id_administrateur VARCHAR(250) NOT NULL, nom VARCHAR(250) NOT NULL, prenom VARCHAR(250) NOT NULL, email VARCHAR(50) NOT NULL, mot_de_passe VARCHAR(250) NOT NULL, date_connexion TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, role VARCHAR(50) NOT NULL, id_service_entretien VARCHAR(100) NOT NULL, id_services_carrosserie VARCHAR(250) NOT NULL, id_mecanique VARCHAR(250) NOT NULL, id_horaire_garage VARCHAR(200) NOT NULL, id_info_garage VARCHAR(100) NOT NULL, PRIMARY KEY(id_administrateur))');
//         $this->addSql('CREATE UNIQUE INDEX UNIQ_32EB52E8E7927C74 ON administrateur (email)');
//         $this->addSql('CREATE TABLE avis (id_avis VARCHAR(200) NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, commentaire TEXT NOT NULL, note NUMERIC(1, 0) NOT NULL, date_avis TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id_avis))');
//         $this->addSql('CREATE TABLE employe (id_employe VARCHAR(250) NOT NULL, nom VARCHAR(250) NOT NULL, prenom VARCHAR(250) NOT NULL, email VARCHAR(250) NOT NULL, mot_de_passe VARCHAR(250) NOT NULL, date_connexion TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, role VARCHAR(50) NOT NULL, id_avis VARCHAR(200) NOT NULL, PRIMARY KEY(id_employe))');
//         $this->addSql('CREATE UNIQUE INDEX UNIQ_F804D3B9E7927C74 ON employe (email)');
//         $this->addSql('CREATE TABLE horaire_garage (id_horaire_garage VARCHAR(200) NOT NULL, jour_de_semaine VARCHAR(15) NOT NULL, heure_douverture TIME(0) WITHOUT TIME ZONE NOT NULL, heure_de_fermeture TIME(0) WITHOUT TIME ZONE NOT NULL, fermeture_garage BOOLEAN NOT NULL, ID_Visiteur VARCHAR(250) DEFAULT NULL, PRIMARY KEY(id_horaire_garage))');
//         $this->addSql('CREATE INDEX IDX_8E4282E02EC9857C ON horaire_garage (ID_Visiteur)');
//         $this->addSql('CREATE TABLE info_garage (id_info_garage VARCHAR(100) NOT NULL, adresse VARCHAR(250) NOT NULL, ville VARCHAR(100) NOT NULL, code_postal VARCHAR(20) NOT NULL, pays VARCHAR(100) NOT NULL, numero_telephone VARCHAR(20) NOT NULL, email VARCHAR(100) NOT NULL, ID_Visiteur VARCHAR(250) DEFAULT NULL, PRIMARY KEY(id_info_garage))');
//         $this->addSql('CREATE UNIQUE INDEX UNIQ_52FB3E5DE7927C74 ON info_garage (email)');
//         $this->addSql('CREATE INDEX IDX_52FB3E5D2EC9857C ON info_garage (ID_Visiteur)');
//         $this->addSql('CREATE TABLE service_carrosserie (id_services_carrosserie VARCHAR(250) NOT NULL, type_service VARCHAR(350) NOT NULL, description_travaux VARCHAR(450) NOT NULL, duree_estimee TIME(0) WITHOUT TIME ZONE NOT NULL, tarif NUMERIC(20, 2) NOT NULL, equipement_utilisee VARCHAR(300) NOT NULL, ID_Visiteur VARCHAR(250) DEFAULT NULL, PRIMARY KEY(id_services_carrosserie))');
//         $this->addSql('CREATE INDEX IDX_FC7E52C32EC9857C ON service_carrosserie (ID_Visiteur)');
//         $this->addSql('CREATE TABLE service_entretien (id_service_entretien VARCHAR(100) NOT NULL, type_service VARCHAR(200) NOT NULL, description_travaux VARCHAR(350) NOT NULL, duree_estimee TIME(0) WITHOUT TIME ZONE NOT NULL, tarif NUMERIC(5, 0) NOT NULL, equipement_utilisee VARCHAR(330) NOT NULL, ID_Visiteur VARCHAR(250) DEFAULT NULL, PRIMARY KEY(id_service_entretien))');
//         $this->addSql('CREATE INDEX IDX_73C9EC902EC9857C ON service_entretien (ID_Visiteur)');
//         $this->addSql('CREATE TABLE service_mecanique (id_mecanique VARCHAR(250) NOT NULL, type_service VARCHAR(350) NOT NULL, description_travaux VARCHAR(500) NOT NULL, duree_estimee TIME(0) WITHOUT TIME ZONE NOT NULL, tarif NUMERIC(20, 2) NOT NULL, equipement_utilisee VARCHAR(250) NOT NULL, ID_Visiteur VARCHAR(250) DEFAULT NULL, PRIMARY KEY(id_mecanique))');
//         $this->addSql('CREATE INDEX IDX_A8C607E92EC9857C ON service_mecanique (ID_Visiteur)');
//         $this->addSql('CREATE TABLE service_vente_voiture_occasion (id_voiture VARCHAR(200) NOT NULL, marque VARCHAR(50) NOT NULL, model VARCHAR(50) NOT NULL, annee_mise_en_circulation DATE NOT NULL, prix NUMERIC(25, 2) NOT NULL, kilometrage INT NOT NULL, description TEXT NOT NULL, image_principale VARCHAR(250) NOT NULL, galerie_images TEXT NOT NULL, caracteristiques TEXT NOT NULL, equipements TEXT NOT NULL, idVisiteur VARCHAR(250) DEFAULT NULL, idEmploye VARCHAR(250) DEFAULT NULL, PRIMARY KEY(id_voiture))');
//         $this->addSql('CREATE INDEX IDX_91DD2A9D1D06ADE3 ON service_vente_voiture_occasion (idVisiteur)');
//         $this->addSql('CREATE INDEX IDX_91DD2A9DE8BDB84B ON service_vente_voiture_occasion (idEmploye)');
//         $this->addSql('CREATE TABLE utilisateur (id_user VARCHAR(100) NOT NULL, email VARCHAR(50) NOT NULL, mot_de_passe VARCHAR(150) NOT NULL, role_utilisateur VARCHAR(50) NOT NULL, date_et_heures_de_connexion TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, idAdministrateur VARCHAR(250) DEFAULT NULL, idEmploye VARCHAR(250) DEFAULT NULL, PRIMARY KEY(id_user))');
//         $this->addSql('CREATE UNIQUE INDEX UNIQ_1D1C63B3E7927C74 ON utilisateur (email)');
//         $this->addSql('CREATE INDEX IDX_1D1C63B3EEF7BB7B ON utilisateur (idAdministrateur)');
//         $this->addSql('CREATE INDEX IDX_1D1C63B3E8BDB84B ON utilisateur (idEmploye)');
//         $this->addSql('CREATE TABLE visiteur (id_visiteur VARCHAR(250) NOT NULL, nom VARCHAR(250) NOT NULL, prenom VARCHAR(250) NOT NULL, date_connexion TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, ID_Avis VARCHAR(200) DEFAULT NULL, PRIMARY KEY(id_visiteur))');
//         $this->addSql('CREATE INDEX IDX_4EA587B86C922466 ON visiteur (ID_Avis)');
//         $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
//         $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
//         $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
//         $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
//         $this->addSql('COMMENT ON COLUMN messenger_messages.created_at IS \'(DC2Type:datetime_immutable)\'');
//         $this->addSql('COMMENT ON COLUMN messenger_messages.available_at IS \'(DC2Type:datetime_immutable)\'');
//         $this->addSql('COMMENT ON COLUMN messenger_messages.delivered_at IS \'(DC2Type:datetime_immutable)\'');
//         $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
//             BEGIN
//                 PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
//                 RETURN NEW;
//             END;
//         $$ LANGUAGE plpgsql;');
//         $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
//         $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
//         $this->addSql('ALTER TABLE horaire_garage ADD CONSTRAINT FK_8E4282E02EC9857C FOREIGN KEY (ID_Visiteur) REFERENCES visiteur (idVisiteur) NOT DEFERRABLE INITIALLY IMMEDIATE');
//         $this->addSql('ALTER TABLE info_garage ADD CONSTRAINT FK_52FB3E5D2EC9857C FOREIGN KEY (ID_Visiteur) REFERENCES visiteur (idVisiteur) NOT DEFERRABLE INITIALLY IMMEDIATE');
//         $this->addSql('ALTER TABLE service_carrosserie ADD CONSTRAINT FK_FC7E52C32EC9857C FOREIGN KEY (ID_Visiteur) REFERENCES visiteur (idVisiteur) NOT DEFERRABLE INITIALLY IMMEDIATE');
//         $this->addSql('ALTER TABLE service_entretien ADD CONSTRAINT FK_73C9EC902EC9857C FOREIGN KEY (ID_Visiteur) REFERENCES visiteur (idVisiteur) NOT DEFERRABLE INITIALLY IMMEDIATE');
//         $this->addSql('ALTER TABLE service_mecanique ADD CONSTRAINT FK_A8C607E92EC9857C FOREIGN KEY (ID_Visiteur) REFERENCES visiteur (idVisiteur) NOT DEFERRABLE INITIALLY IMMEDIATE');
//         $this->addSql('ALTER TABLE service_vente_voiture_occasion ADD CONSTRAINT FK_91DD2A9D1D06ADE3 FOREIGN KEY (idVisiteur) REFERENCES visiteur (idVisiteur) NOT DEFERRABLE INITIALLY IMMEDIATE');
//         $this->addSql('ALTER TABLE service_vente_voiture_occasion ADD CONSTRAINT FK_91DD2A9DE8BDB84B FOREIGN KEY (idEmploye) REFERENCES employe (idEmploye) NOT DEFERRABLE INITIALLY IMMEDIATE');
//         $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3EEF7BB7B FOREIGN KEY (idAdministrateur) REFERENCES administrateur (idAdministrateur) NOT DEFERRABLE INITIALLY IMMEDIATE');
//         $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3E8BDB84B FOREIGN KEY (idEmploye) REFERENCES employe (idEmploye) NOT DEFERRABLE INITIALLY IMMEDIATE');
//         $this->addSql('ALTER TABLE visiteur ADD CONSTRAINT FK_4EA587B86C922466 FOREIGN KEY (ID_Avis) REFERENCES avis (idAvis) NOT DEFERRABLE INITIALLY IMMEDIATE');
//     }

//     public function down(Schema $schema): void
//     {
//         // this down() migration is auto-generated, please modify it to your needs
//         $this->addSql('CREATE SCHEMA public');
//         $this->addSql('ALTER TABLE horaire_garage DROP CONSTRAINT FK_8E4282E02EC9857C');
//         $this->addSql('ALTER TABLE info_garage DROP CONSTRAINT FK_52FB3E5D2EC9857C');
//         $this->addSql('ALTER TABLE service_carrosserie DROP CONSTRAINT FK_FC7E52C32EC9857C');
//         $this->addSql('ALTER TABLE service_entretien DROP CONSTRAINT FK_73C9EC902EC9857C');
//         $this->addSql('ALTER TABLE service_mecanique DROP CONSTRAINT FK_A8C607E92EC9857C');
//         $this->addSql('ALTER TABLE service_vente_voiture_occasion DROP CONSTRAINT FK_91DD2A9D1D06ADE3');
//         $this->addSql('ALTER TABLE service_vente_voiture_occasion DROP CONSTRAINT FK_91DD2A9DE8BDB84B');
//         $this->addSql('ALTER TABLE utilisateur DROP CONSTRAINT FK_1D1C63B3EEF7BB7B');
//         $this->addSql('ALTER TABLE utilisateur DROP CONSTRAINT FK_1D1C63B3E8BDB84B');
//         $this->addSql('ALTER TABLE visiteur DROP CONSTRAINT FK_4EA587B86C922466');
//         $this->addSql('DROP TABLE administrateur');
//         $this->addSql('DROP TABLE avis');
//         $this->addSql('DROP TABLE employe');
//         $this->addSql('DROP TABLE horaire_garage');
//         $this->addSql('DROP TABLE info_garage');
//         $this->addSql('DROP TABLE service_carrosserie');
//         $this->addSql('DROP TABLE service_entretien');
//         $this->addSql('DROP TABLE service_mecanique');
//         $this->addSql('DROP TABLE service_vente_voiture_occasion');
//         $this->addSql('DROP TABLE utilisateur');
//         $this->addSql('DROP TABLE visiteur');
//         $this->addSql('DROP TABLE messenger_messages');
//     }
// }
