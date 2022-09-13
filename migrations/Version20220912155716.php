<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220912155716 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE voiture (id INT AUTO_INCREMENT NOT NULL, libelle_annonce VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, prix VARCHAR(255) DEFAULT NULL, lien_video VARCHAR(255) DEFAULT NULL, is_uptodate TINYINT(1) DEFAULT 1 NOT NULL, slug VARCHAR(255) NOT NULL, is_paye TINYINT(1) DEFAULT 0 NOT NULL, is_cime TINYINT(1) DEFAULT 0 NOT NULL, is_vendu TINYINT(1) DEFAULT 0 NOT NULL, is_pro TINYINT(1) DEFAULT 0 NOT NULL, nb_vus BIGINT DEFAULT 0 NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', annee INT NOT NULL, UNIQUE INDEX UNIQ_E9E2810F989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE voiture');
    }
}
