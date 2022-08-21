<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220821155028 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE adresse (id INT AUTO_INCREMENT NOT NULL, pays VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, details VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE info_perso (id INT AUTO_INCREMENT NOT NULL, telephone VARCHAR(255) DEFAULT NULL, whatsapp VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE annonce ADD adresse_id INT DEFAULT NULL, ADD is_paye TINYINT(1) NOT NULL, ADD is_cime TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E54DE7DC5C FOREIGN KEY (adresse_id) REFERENCES adresse (id)');
        $this->addSql('CREATE INDEX IDX_F65593E54DE7DC5C ON annonce (adresse_id)');
        $this->addSql('ALTER TABLE salle_exposition ADD adresse_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE salle_exposition ADD CONSTRAINT FK_D7BD088B4DE7DC5C FOREIGN KEY (adresse_id) REFERENCES adresse (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D7BD088B4DE7DC5C ON salle_exposition (adresse_id)');
        $this->addSql('ALTER TABLE user ADD adresse_id INT DEFAULT NULL, ADD contacts_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6494DE7DC5C FOREIGN KEY (adresse_id) REFERENCES adresse (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649719FB48E FOREIGN KEY (contacts_id) REFERENCES info_perso (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6494DE7DC5C ON user (adresse_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649719FB48E ON user (contacts_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E54DE7DC5C');
        $this->addSql('ALTER TABLE salle_exposition DROP FOREIGN KEY FK_D7BD088B4DE7DC5C');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6494DE7DC5C');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649719FB48E');
        $this->addSql('DROP TABLE adresse');
        $this->addSql('DROP TABLE info_perso');
        $this->addSql('DROP INDEX IDX_F65593E54DE7DC5C ON annonce');
        $this->addSql('ALTER TABLE annonce DROP adresse_id, DROP is_paye, DROP is_cime');
        $this->addSql('DROP INDEX UNIQ_8D93D6494DE7DC5C ON user');
        $this->addSql('DROP INDEX UNIQ_8D93D649719FB48E ON user');
        $this->addSql('ALTER TABLE user DROP adresse_id, DROP contacts_id');
        $this->addSql('DROP INDEX UNIQ_D7BD088B4DE7DC5C ON salle_exposition');
        $this->addSql('ALTER TABLE salle_exposition DROP adresse_id');
    }
}
