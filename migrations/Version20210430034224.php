<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210430034224 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE booking (id INT AUTO_INCREMENT NOT NULL, begin_at DATETIME NOT NULL, end_at DATETIME DEFAULT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE entrainement DROP nom_equipee, DROP nom_coache, DROP nom_stadee');
        $this->addSql('ALTER TABLE equipe CHANGE id_coach id_coach INT DEFAULT NULL');
        $this->addSql('ALTER TABLE equipe ADD CONSTRAINT FK_2449BA15D1DC2CFC FOREIGN KEY (id_coach) REFERENCES coach (id_coach)');
        $this->addSql('ALTER TABLE joueur CHANGE id_equipe id_equipe INT DEFAULT NULL');
        $this->addSql('DROP INDEX secondary ON joueur');
        $this->addSql('CREATE INDEX id_e ON joueur (id_equipe)');
        $this->addSql('ALTER TABLE prioriterec DROP FOREIGN KEY prioriterec_ibfk_1');
        $this->addSql('ALTER TABLE prioriterec CHANGE idRec idRec INT DEFAULT NULL');
        $this->addSql('ALTER TABLE prioriterec ADD CONSTRAINT FK_51F0FEC2454DD7AB FOREIGN KEY (idRec) REFERENCES reclamation (idRec)');
        $this->addSql('ALTER TABLE rate CHANGE idCoach idCoach INT DEFAULT NULL, CHANGE NomPrenomCoach NomPrenomCoach VARCHAR(50) DEFAULT \'NULL\', CHANGE NomEquipe NomEquipe VARCHAR(50) DEFAULT \'NULL\', CHANGE DateRate DateRate DATE DEFAULT \'NULL\', CHANGE Rate Rate INT DEFAULT NULL');
        $this->addSql('DROP INDEX id_joueur ON reclamation');
        $this->addSql('ALTER TABLE reclamation CHANGE DateTraitement DateTraitement DATE DEFAULT \'NULL\', CHANGE NomPrenomCoach NomPrenomCoach VARCHAR(50) DEFAULT \'NULL\', CHANGE imgRec imgRec VARCHAR(255) DEFAULT \'NULL\', CHANGE Opened Opened INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE booking');
        $this->addSql('ALTER TABLE entrainement ADD nom_equipee VARCHAR(255) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, ADD nom_coache VARCHAR(255) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, ADD nom_stadee VARCHAR(255) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`');
        $this->addSql('ALTER TABLE equipe DROP FOREIGN KEY FK_2449BA15D1DC2CFC');
        $this->addSql('ALTER TABLE equipe CHANGE id_coach id_coach INT NOT NULL');
        $this->addSql('ALTER TABLE joueur DROP FOREIGN KEY FK_FD71A9C527E0FF8');
        $this->addSql('ALTER TABLE joueur DROP FOREIGN KEY FK_FD71A9C527E0FF8');
        $this->addSql('ALTER TABLE joueur CHANGE id_equipe id_equipe INT NOT NULL');
        $this->addSql('DROP INDEX id_e ON joueur');
        $this->addSql('CREATE INDEX SECONDARY ON joueur (id_equipe)');
        $this->addSql('ALTER TABLE joueur ADD CONSTRAINT FK_FD71A9C527E0FF8 FOREIGN KEY (id_equipe) REFERENCES equipe (id_e)');
        $this->addSql('ALTER TABLE prioriterec DROP FOREIGN KEY FK_51F0FEC2454DD7AB');
        $this->addSql('ALTER TABLE prioriterec CHANGE idRec idRec INT NOT NULL');
        $this->addSql('ALTER TABLE prioriterec ADD CONSTRAINT prioriterec_ibfk_1 FOREIGN KEY (idRec) REFERENCES reclamation (idRec) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rate CHANGE idCoach idCoach INT DEFAULT NULL, CHANGE NomPrenomCoach NomPrenomCoach VARCHAR(50) CHARACTER SET latin1 DEFAULT NULL COLLATE `latin1_swedish_ci`, CHANGE NomEquipe NomEquipe VARCHAR(50) CHARACTER SET latin1 DEFAULT NULL COLLATE `latin1_swedish_ci`, CHANGE DateRate DateRate DATE DEFAULT NULL, CHANGE Rate Rate INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reclamation CHANGE DateTraitement DateTraitement DATE DEFAULT NULL, CHANGE NomPrenomCoach NomPrenomCoach VARCHAR(50) CHARACTER SET latin1 DEFAULT NULL COLLATE `latin1_swedish_ci`, CHANGE imgRec imgRec VARCHAR(255) CHARACTER SET latin1 DEFAULT NULL COLLATE `latin1_swedish_ci`, CHANGE Opened Opened INT DEFAULT 0 NOT NULL');
        $this->addSql('CREATE INDEX id_joueur ON reclamation (idJoueur)');
    }
}
