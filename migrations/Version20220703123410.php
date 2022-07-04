<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220703123410 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fichier_medical DROP FOREIGN KEY FK_AC48FB6D611C0C56');
        $this->addSql('DROP TABLE dossier_medical');
        $this->addSql('DROP INDEX IDX_AC48FB6D611C0C56 ON fichier_medical');
        $this->addSql('ALTER TABLE fichier_medical CHANGE dossier_id dossier_medical_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE fichier_medical ADD CONSTRAINT FK_AC48FB6D7750B79F FOREIGN KEY (dossier_medical_id) REFERENCES assure (id)');
        $this->addSql('CREATE INDEX IDX_AC48FB6D7750B79F ON fichier_medical (dossier_medical_id)');
        $this->addSql('ALTER TABLE medicament ADD quantite INT NOT NULL, ADD posologie VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE notification ADD statut VARCHAR(255) NOT NULL, CHANGE libelle body VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE dossier_medical (id INT AUTO_INCREMENT NOT NULL, assure_id INT DEFAULT NULL, INDEX IDX_3581EE621F4BE942 (assure_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE dossier_medical ADD CONSTRAINT FK_3581EE621F4BE942 FOREIGN KEY (assure_id) REFERENCES assure (id)');
        $this->addSql('ALTER TABLE fichier_medical DROP FOREIGN KEY FK_AC48FB6D7750B79F');
        $this->addSql('DROP INDEX IDX_AC48FB6D7750B79F ON fichier_medical');
        $this->addSql('ALTER TABLE fichier_medical CHANGE dossier_medical_id dossier_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE fichier_medical ADD CONSTRAINT FK_AC48FB6D611C0C56 FOREIGN KEY (dossier_id) REFERENCES dossier_medical (id)');
        $this->addSql('CREATE INDEX IDX_AC48FB6D611C0C56 ON fichier_medical (dossier_id)');
        $this->addSql('ALTER TABLE medicament DROP quantite, DROP posologie');
        $this->addSql('ALTER TABLE notification ADD libelle VARCHAR(255) NOT NULL, DROP body, DROP statut');
    }
}
