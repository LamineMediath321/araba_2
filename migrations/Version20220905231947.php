<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220905231947 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE salle_exposition ADD categorie_id INT DEFAULT NULL, DROP created_at, DROP updated_at');
        $this->addSql('ALTER TABLE salle_exposition ADD CONSTRAINT FK_D7BD088BBCF5E72D FOREIGN KEY (categorie_id) REFERENCES sous_categorie (id)');
        $this->addSql('CREATE INDEX IDX_D7BD088BBCF5E72D ON salle_exposition (categorie_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE salle_exposition DROP FOREIGN KEY FK_D7BD088BBCF5E72D');
        $this->addSql('DROP INDEX IDX_D7BD088BBCF5E72D ON salle_exposition');
        $this->addSql('ALTER TABLE salle_exposition ADD created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', DROP categorie_id');
    }
}
