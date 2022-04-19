<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220419180005 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE image_annonce (id INT AUTO_INCREMENT NOT NULL, article_id INT NOT NULL, image_name VARCHAR(255) DEFAULT NULL, INDEX IDX_6345C4397294869C (article_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE salle_exposition (id INT AUTO_INCREMENT NOT NULL, domaine_id INT DEFAULT NULL, owner_id INT NOT NULL, nom_salle VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, image_name VARCHAR(255) DEFAULT NULL, addresse_salle LONGTEXT DEFAULT NULL, INDEX IDX_D7BD088B4272FC9F (domaine_id), UNIQUE INDEX UNIQ_D7BD088B7E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE image_annonce ADD CONSTRAINT FK_6345C4397294869C FOREIGN KEY (article_id) REFERENCES annonce (id)');
        $this->addSql('ALTER TABLE salle_exposition ADD CONSTRAINT FK_D7BD088B4272FC9F FOREIGN KEY (domaine_id) REFERENCES sous_categorie (id)');
        $this->addSql('ALTER TABLE salle_exposition ADD CONSTRAINT FK_D7BD088B7E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE image_annonce');
        $this->addSql('DROP TABLE salle_exposition');
    }
}
