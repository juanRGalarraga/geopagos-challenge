<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250214232458 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, tournament_id_id INT NOT NULL, player1_id_id INT NOT NULL, player2_id_id INT NOT NULL, round INT NOT NULL, INDEX IDX_232B318CBE120E4E (tournament_id_id), UNIQUE INDEX UNIQ_232B318CB1F5D3AD (player1_id_id), UNIQUE INDEX UNIQ_232B318C801DC930 (player2_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participation (id INT AUTO_INCREMENT NOT NULL, tournament_id_id INT NOT NULL, player_id_id INT NOT NULL, INDEX IDX_AB55E24FBE120E4E (tournament_id_id), INDEX IDX_AB55E24FC036E511 (player_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE player (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, skill_level INT NOT NULL, genre VARCHAR(255) NOT NULL, strength INT DEFAULT NULL, speed INT DEFAULT NULL, reaction_time INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tournament (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, date DATETIME NOT NULL, winner_id INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318CBE120E4E FOREIGN KEY (tournament_id_id) REFERENCES tournament (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318CB1F5D3AD FOREIGN KEY (player1_id_id) REFERENCES player (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C801DC930 FOREIGN KEY (player2_id_id) REFERENCES player (id)');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT FK_AB55E24FBE120E4E FOREIGN KEY (tournament_id_id) REFERENCES tournament (id)');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT FK_AB55E24FC036E511 FOREIGN KEY (player_id_id) REFERENCES player (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318CBE120E4E');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318CB1F5D3AD');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C801DC930');
        $this->addSql('ALTER TABLE participation DROP FOREIGN KEY FK_AB55E24FBE120E4E');
        $this->addSql('ALTER TABLE participation DROP FOREIGN KEY FK_AB55E24FC036E511');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE participation');
        $this->addSql('DROP TABLE player');
        $this->addSql('DROP TABLE tournament');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
