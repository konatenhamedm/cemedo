<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220610163921 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE assurance (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dossier_medical (id INT AUTO_INCREMENT NOT NULL, assure_id INT DEFAULT NULL, INDEX IDX_3581EE621F4BE942 (assure_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fichier_medical (id INT AUTO_INCREMENT NOT NULL, dossier_id INT DEFAULT NULL, type_fichier_id INT DEFAULT NULL, INDEX IDX_AC48FB6D611C0C56 (dossier_id), INDEX IDX_AC48FB6D12928ADB (type_fichier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE medicament (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ordonnance (id INT AUTO_INCREMENT NOT NULL, assure_id INT DEFAULT NULL, medicament_id INT DEFAULT NULL, INDEX IDX_924B326C1F4BE942 (assure_id), INDEX IDX_924B326CAB0D61F7 (medicament_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rendez_vous (id INT AUTO_INCREMENT NOT NULL, gerant_id INT DEFAULT NULL, emetteur_id INT DEFAULT NULL, concerne_id INT DEFAULT NULL, medecin_id INT DEFAULT NULL, service_id INT DEFAULT NULL, INDEX IDX_65E8AA0AA500A924 (gerant_id), INDEX IDX_65E8AA0A79E92E8C (emetteur_id), INDEX IDX_65E8AA0A6406FEF1 (concerne_id), INDEX IDX_65E8AA0A4F31A84 (medecin_id), INDEX IDX_65E8AA0AED5CA9E6 (service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, type_service_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, INDEX IDX_E19D9AD2F05F7FC3 (type_service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_fichier_medical (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_service (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE dossier_medical ADD CONSTRAINT FK_3581EE621F4BE942 FOREIGN KEY (assure_id) REFERENCES assure (id)');
        $this->addSql('ALTER TABLE fichier_medical ADD CONSTRAINT FK_AC48FB6D611C0C56 FOREIGN KEY (dossier_id) REFERENCES dossier_medical (id)');
        $this->addSql('ALTER TABLE fichier_medical ADD CONSTRAINT FK_AC48FB6D12928ADB FOREIGN KEY (type_fichier_id) REFERENCES type_fichier_medical (id)');
        $this->addSql('ALTER TABLE ordonnance ADD CONSTRAINT FK_924B326C1F4BE942 FOREIGN KEY (assure_id) REFERENCES assure (id)');
        $this->addSql('ALTER TABLE ordonnance ADD CONSTRAINT FK_924B326CAB0D61F7 FOREIGN KEY (medicament_id) REFERENCES medicament (id)');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0AA500A924 FOREIGN KEY (gerant_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0A79E92E8C FOREIGN KEY (emetteur_id) REFERENCES assure (id)');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0A6406FEF1 FOREIGN KEY (concerne_id) REFERENCES assure (id)');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0A4F31A84 FOREIGN KEY (medecin_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0AED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD2F05F7FC3 FOREIGN KEY (type_service_id) REFERENCES type_service (id)');
        $this->addSql('ALTER TABLE assure ADD assurance_id INT DEFAULT NULL, ADD patient_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE assure ADD CONSTRAINT FK_C779CC29B288C3E3 FOREIGN KEY (assurance_id) REFERENCES assurance (id)');
        $this->addSql('ALTER TABLE assure ADD CONSTRAINT FK_C779CC296B899279 FOREIGN KEY (patient_id) REFERENCES assure (id)');
        $this->addSql('CREATE INDEX IDX_C779CC29B288C3E3 ON assure (assurance_id)');
        $this->addSql('CREATE INDEX IDX_C779CC296B899279 ON assure (patient_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE assure DROP FOREIGN KEY FK_C779CC29B288C3E3');
        $this->addSql('ALTER TABLE fichier_medical DROP FOREIGN KEY FK_AC48FB6D611C0C56');
        $this->addSql('ALTER TABLE ordonnance DROP FOREIGN KEY FK_924B326CAB0D61F7');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0AED5CA9E6');
        $this->addSql('ALTER TABLE fichier_medical DROP FOREIGN KEY FK_AC48FB6D12928ADB');
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD2F05F7FC3');
        $this->addSql('DROP TABLE assurance');
        $this->addSql('DROP TABLE dossier_medical');
        $this->addSql('DROP TABLE fichier_medical');
        $this->addSql('DROP TABLE medicament');
        $this->addSql('DROP TABLE ordonnance');
        $this->addSql('DROP TABLE rendez_vous');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE type_fichier_medical');
        $this->addSql('DROP TABLE type_service');
        $this->addSql('ALTER TABLE assure DROP FOREIGN KEY FK_C779CC296B899279');
        $this->addSql('DROP INDEX IDX_C779CC29B288C3E3 ON assure');
        $this->addSql('DROP INDEX IDX_C779CC296B899279 ON assure');
        $this->addSql('ALTER TABLE assure DROP assurance_id, DROP patient_id');
    }
}
