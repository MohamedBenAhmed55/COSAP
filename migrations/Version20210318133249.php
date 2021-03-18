<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210318133249 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE chef_groupe (id INT AUTO_INCREMENT NOT NULL, company_id INT DEFAULT NULL, date_deb DATE NOT NULL, date_fin DATE NOT NULL, INDEX IDX_17DC5A979B1AD6 (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE company (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, postalcode VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, logo VARCHAR(255) NOT NULL, matricule_fiscale VARCHAR(255) NOT NULL, secteur_activite VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE groupe (id INT AUTO_INCREMENT NOT NULL, chef_id INT DEFAULT NULL, company_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_4B98C21150A48F1 (chef_id), INDEX IDX_4B98C21979B1AD6 (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE heures_travail (id INT AUTO_INCREMENT NOT NULL, company_id INT DEFAULT NULL, heure_deb TIME NOT NULL, heure_fin TIME NOT NULL, heure_deb_pause TIME NOT NULL, heure_fin_pause TIME NOT NULL, is_seance_unique TINYINT(1) NOT NULL, INDEX IDX_1847E8C8979B1AD6 (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE jours_feries (id INT AUTO_INCREMENT NOT NULL, company_id INT DEFAULT NULL, date DATE NOT NULL, titre VARCHAR(255) NOT NULL, INDEX IDX_9B22B9FC979B1AD6 (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE poste (id INT AUTO_INCREMENT NOT NULL, company_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_7C890FAB979B1AD6 (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE salle (id INT AUTO_INCREMENT NOT NULL, company_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, etage INT NOT NULL, INDEX IDX_4E977E5C979B1AD6 (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE chef_groupe ADD CONSTRAINT FK_17DC5A979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE groupe ADD CONSTRAINT FK_4B98C21150A48F1 FOREIGN KEY (chef_id) REFERENCES chef_groupe (id)');
        $this->addSql('ALTER TABLE groupe ADD CONSTRAINT FK_4B98C21979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE heures_travail ADD CONSTRAINT FK_1847E8C8979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE jours_feries ADD CONSTRAINT FK_9B22B9FC979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE poste ADD CONSTRAINT FK_7C890FAB979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE salle ADD CONSTRAINT FK_4E977E5C979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE groupe DROP FOREIGN KEY FK_4B98C21150A48F1');
        $this->addSql('ALTER TABLE chef_groupe DROP FOREIGN KEY FK_17DC5A979B1AD6');
        $this->addSql('ALTER TABLE groupe DROP FOREIGN KEY FK_4B98C21979B1AD6');
        $this->addSql('ALTER TABLE heures_travail DROP FOREIGN KEY FK_1847E8C8979B1AD6');
        $this->addSql('ALTER TABLE jours_feries DROP FOREIGN KEY FK_9B22B9FC979B1AD6');
        $this->addSql('ALTER TABLE poste DROP FOREIGN KEY FK_7C890FAB979B1AD6');
        $this->addSql('ALTER TABLE salle DROP FOREIGN KEY FK_4E977E5C979B1AD6');
        $this->addSql('DROP TABLE chef_groupe');
        $this->addSql('DROP TABLE company');
        $this->addSql('DROP TABLE groupe');
        $this->addSql('DROP TABLE heures_travail');
        $this->addSql('DROP TABLE jours_feries');
        $this->addSql('DROP TABLE poste');
        $this->addSql('DROP TABLE salle');
    }
}
