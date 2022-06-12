<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220611124402 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE assurance (id INT AUTO_INCREMENT NOT NULL, nom_assurance VARCHAR(255) NOT NULL, email_assurance VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE assure (id INT AUTO_INCREMENT NOT NULL, assurance_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_C779CC29E7927C74 (email), INDEX IDX_C779CC29B288C3E3 (assurance_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dossier_medical (id INT AUTO_INCREMENT NOT NULL, assure_id INT DEFAULT NULL, INDEX IDX_3581EE621F4BE942 (assure_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE facture (id INT AUTO_INCREMENT NOT NULL, administrateur_id INT DEFAULT NULL, date_livraison DATETIME NOT NULL, date_creation DATETIME NOT NULL, status VARCHAR(255) NOT NULL, INDEX IDX_FE8664107EE5403C (administrateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fichier_medical (id INT AUTO_INCREMENT NOT NULL, dossier_id INT DEFAULT NULL, type_fichier_id INT DEFAULT NULL, INDEX IDX_AC48FB6D611C0C56 (dossier_id), INDEX IDX_AC48FB6D12928ADB (type_fichier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE medicament (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE membre_famille (id INT NOT NULL, patient_id INT DEFAULT NULL, INDEX IDX_9654F0AE6B899279 (patient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notification (id INT AUTO_INCREMENT NOT NULL, patient_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, date_notif DATETIME NOT NULL, INDEX IDX_BF5476CA6B899279 (patient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ordonnance (id INT AUTO_INCREMENT NOT NULL, assure_id INT DEFAULT NULL, medicament_id INT DEFAULT NULL, INDEX IDX_924B326C1F4BE942 (assure_id), INDEX IDX_924B326CAB0D61F7 (medicament_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE patient (id INT NOT NULL, numero_assurance VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rendez_vous (id INT AUTO_INCREMENT NOT NULL, gerant_id INT DEFAULT NULL, emetteur_id INT DEFAULT NULL, concerne_id INT DEFAULT NULL, medecin_id INT DEFAULT NULL, service_id INT DEFAULT NULL, INDEX IDX_65E8AA0AA500A924 (gerant_id), INDEX IDX_65E8AA0A79E92E8C (emetteur_id), INDEX IDX_65E8AA0A6406FEF1 (concerne_id), INDEX IDX_65E8AA0A4F31A84 (medecin_id), INDEX IDX_65E8AA0AED5CA9E6 (service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, type_service_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, INDEX IDX_E19D9AD2F05F7FC3 (type_service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_fichier_medical (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_service (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, salaire_medecin DOUBLE PRECISION DEFAULT NULL, salaire_infirmier DOUBLE PRECISION DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE assure ADD CONSTRAINT FK_C779CC29B288C3E3 FOREIGN KEY (assurance_id) REFERENCES assurance (id)');
        $this->addSql('ALTER TABLE dossier_medical ADD CONSTRAINT FK_3581EE621F4BE942 FOREIGN KEY (assure_id) REFERENCES assure (id)');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT FK_FE8664107EE5403C FOREIGN KEY (administrateur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE fichier_medical ADD CONSTRAINT FK_AC48FB6D611C0C56 FOREIGN KEY (dossier_id) REFERENCES dossier_medical (id)');
        $this->addSql('ALTER TABLE fichier_medical ADD CONSTRAINT FK_AC48FB6D12928ADB FOREIGN KEY (type_fichier_id) REFERENCES type_fichier_medical (id)');
        $this->addSql('ALTER TABLE membre_famille ADD CONSTRAINT FK_9654F0AE6B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE membre_famille ADD CONSTRAINT FK_9654F0AEBF396750 FOREIGN KEY (id) REFERENCES assure (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CA6B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE ordonnance ADD CONSTRAINT FK_924B326C1F4BE942 FOREIGN KEY (assure_id) REFERENCES assure (id)');
        $this->addSql('ALTER TABLE ordonnance ADD CONSTRAINT FK_924B326CAB0D61F7 FOREIGN KEY (medicament_id) REFERENCES medicament (id)');
        $this->addSql('ALTER TABLE patient ADD CONSTRAINT FK_1ADAD7EBBF396750 FOREIGN KEY (id) REFERENCES assure (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0AA500A924 FOREIGN KEY (gerant_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0A79E92E8C FOREIGN KEY (emetteur_id) REFERENCES assure (id)');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0A6406FEF1 FOREIGN KEY (concerne_id) REFERENCES assure (id)');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0A4F31A84 FOREIGN KEY (medecin_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0AED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD2F05F7FC3 FOREIGN KEY (type_service_id) REFERENCES type_service (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE assure DROP FOREIGN KEY FK_C779CC29B288C3E3');
        $this->addSql('ALTER TABLE dossier_medical DROP FOREIGN KEY FK_3581EE621F4BE942');
        $this->addSql('ALTER TABLE membre_famille DROP FOREIGN KEY FK_9654F0AEBF396750');
        $this->addSql('ALTER TABLE ordonnance DROP FOREIGN KEY FK_924B326C1F4BE942');
        $this->addSql('ALTER TABLE patient DROP FOREIGN KEY FK_1ADAD7EBBF396750');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0A79E92E8C');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0A6406FEF1');
        $this->addSql('ALTER TABLE fichier_medical DROP FOREIGN KEY FK_AC48FB6D611C0C56');
        $this->addSql('ALTER TABLE ordonnance DROP FOREIGN KEY FK_924B326CAB0D61F7');
        $this->addSql('ALTER TABLE membre_famille DROP FOREIGN KEY FK_9654F0AE6B899279');
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CA6B899279');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0AED5CA9E6');
        $this->addSql('ALTER TABLE fichier_medical DROP FOREIGN KEY FK_AC48FB6D12928ADB');
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD2F05F7FC3');
        $this->addSql('ALTER TABLE facture DROP FOREIGN KEY FK_FE8664107EE5403C');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0AA500A924');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0A4F31A84');
        $this->addSql('DROP TABLE assurance');
        $this->addSql('DROP TABLE assure');
        $this->addSql('DROP TABLE dossier_medical');
        $this->addSql('DROP TABLE facture');
        $this->addSql('DROP TABLE fichier_medical');
        $this->addSql('DROP TABLE medicament');
        $this->addSql('DROP TABLE membre_famille');
        $this->addSql('DROP TABLE notification');
        $this->addSql('DROP TABLE ordonnance');
        $this->addSql('DROP TABLE patient');
        $this->addSql('DROP TABLE rendez_vous');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE type_fichier_medical');
        $this->addSql('DROP TABLE type_service');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
