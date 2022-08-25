<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220824200524 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE info_perso ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE info_perso ADD CONSTRAINT FK_B73B3FD4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B73B3FD4A76ED395 ON info_perso (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE info_perso DROP FOREIGN KEY FK_B73B3FD4A76ED395');
        $this->addSql('DROP INDEX UNIQ_B73B3FD4A76ED395 ON info_perso');
        $this->addSql('ALTER TABLE info_perso DROP user_id');
    }
}
