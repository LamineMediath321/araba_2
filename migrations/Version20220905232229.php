<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220905232229 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE salle_exposition DROP FOREIGN KEY FK_D7BD088BBCF5E72D');
        $this->addSql('DROP INDEX IDX_D7BD088BBCF5E72D ON salle_exposition');
        $this->addSql('ALTER TABLE salle_exposition DROP categorie_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE salle_exposition ADD categorie_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE salle_exposition ADD CONSTRAINT FK_D7BD088BBCF5E72D FOREIGN KEY (categorie_id) REFERENCES sous_categorie (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_D7BD088BBCF5E72D ON salle_exposition (categorie_id)');
    }
}
