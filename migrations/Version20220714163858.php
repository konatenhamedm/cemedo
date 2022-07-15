<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220714163858 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE facture DROP FOREIGN KEY FK_FE8664107EE5403C');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0AA500A924');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0A4F31A84');
        $this->addSql('DROP TABLE userd');
        $this->addSql('ALTER TABLE facture DROP FOREIGN KEY FK_FE8664107EE5403C');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT FK_FE8664107EE5403C FOREIGN KEY (administrateur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE livraison ADD assure_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE livraison ADD CONSTRAINT FK_A60C9F1F1F4BE942 FOREIGN KEY (assure_id) REFERENCES assure (id)');
        $this->addSql('CREATE INDEX IDX_A60C9F1F1F4BE942 ON livraison (assure_id)');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0AA500A924');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0A4F31A84');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0AA500A924 FOREIGN KEY (gerant_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0A4F31A84 FOREIGN KEY (medecin_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64919F0CCA1 FOREIGN KEY (type_medecin_id) REFERENCES type_medecin (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE userd (id INT AUTO_INCREMENT NOT NULL, type_medecin_id INT DEFAULT NULL, INDEX IDX_8D93D64919F0CCA1 (type_medecin_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE userd ADD CONSTRAINT FK_8D93D64919F0CCA1 FOREIGN KEY (type_medecin_id) REFERENCES type_medecin (id)');
        $this->addSql('ALTER TABLE facture DROP FOREIGN KEY FK_FE8664107EE5403C');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT FK_FE8664107EE5403C FOREIGN KEY (administrateur_id) REFERENCES userd (id)');
        $this->addSql('ALTER TABLE livraison DROP FOREIGN KEY FK_A60C9F1F1F4BE942');
        $this->addSql('DROP INDEX IDX_A60C9F1F1F4BE942 ON livraison');
        $this->addSql('ALTER TABLE livraison DROP assure_id');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0AA500A924');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0A4F31A84');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0AA500A924 FOREIGN KEY (gerant_id) REFERENCES userd (id)');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0A4F31A84 FOREIGN KEY (medecin_id) REFERENCES userd (id)');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64919F0CCA1');
    }
}
