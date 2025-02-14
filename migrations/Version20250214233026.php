<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250214233026 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318CB1F5D3AD');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318CBE120E4E');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C801DC930');
        $this->addSql('DROP INDEX UNIQ_232B318CB1F5D3AD ON game');
        $this->addSql('DROP INDEX UNIQ_232B318C801DC930 ON game');
        $this->addSql('DROP INDEX IDX_232B318CBE120E4E ON game');
        $this->addSql('ALTER TABLE game ADD tournament_id INT NOT NULL, ADD player1_id INT NOT NULL, ADD player2_id INT NOT NULL, DROP tournament_id_id, DROP player1_id_id, DROP player2_id_id');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C33D1A3E7 FOREIGN KEY (tournament_id) REFERENCES tournament (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318CC0990423 FOREIGN KEY (player1_id) REFERENCES player (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318CD22CABCD FOREIGN KEY (player2_id) REFERENCES player (id)');
        $this->addSql('CREATE INDEX IDX_232B318C33D1A3E7 ON game (tournament_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_232B318CC0990423 ON game (player1_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_232B318CD22CABCD ON game (player2_id)');
        $this->addSql('ALTER TABLE participation DROP FOREIGN KEY FK_AB55E24FBE120E4E');
        $this->addSql('ALTER TABLE participation DROP FOREIGN KEY FK_AB55E24FC036E511');
        $this->addSql('DROP INDEX IDX_AB55E24FBE120E4E ON participation');
        $this->addSql('DROP INDEX IDX_AB55E24FC036E511 ON participation');
        $this->addSql('ALTER TABLE participation ADD tournament_id INT NOT NULL, ADD player_id INT NOT NULL, DROP tournament_id_id, DROP player_id_id');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT FK_AB55E24F33D1A3E7 FOREIGN KEY (tournament_id) REFERENCES tournament (id)');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT FK_AB55E24F99E6F5DF FOREIGN KEY (player_id) REFERENCES player (id)');
        $this->addSql('CREATE INDEX IDX_AB55E24F33D1A3E7 ON participation (tournament_id)');
        $this->addSql('CREATE INDEX IDX_AB55E24F99E6F5DF ON participation (player_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C33D1A3E7');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318CC0990423');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318CD22CABCD');
        $this->addSql('DROP INDEX IDX_232B318C33D1A3E7 ON game');
        $this->addSql('DROP INDEX UNIQ_232B318CC0990423 ON game');
        $this->addSql('DROP INDEX UNIQ_232B318CD22CABCD ON game');
        $this->addSql('ALTER TABLE game ADD tournament_id_id INT NOT NULL, ADD player1_id_id INT NOT NULL, ADD player2_id_id INT NOT NULL, DROP tournament_id, DROP player1_id, DROP player2_id');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318CB1F5D3AD FOREIGN KEY (player1_id_id) REFERENCES player (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318CBE120E4E FOREIGN KEY (tournament_id_id) REFERENCES tournament (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C801DC930 FOREIGN KEY (player2_id_id) REFERENCES player (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_232B318CB1F5D3AD ON game (player1_id_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_232B318C801DC930 ON game (player2_id_id)');
        $this->addSql('CREATE INDEX IDX_232B318CBE120E4E ON game (tournament_id_id)');
        $this->addSql('ALTER TABLE participation DROP FOREIGN KEY FK_AB55E24F33D1A3E7');
        $this->addSql('ALTER TABLE participation DROP FOREIGN KEY FK_AB55E24F99E6F5DF');
        $this->addSql('DROP INDEX IDX_AB55E24F33D1A3E7 ON participation');
        $this->addSql('DROP INDEX IDX_AB55E24F99E6F5DF ON participation');
        $this->addSql('ALTER TABLE participation ADD tournament_id_id INT NOT NULL, ADD player_id_id INT NOT NULL, DROP tournament_id, DROP player_id');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT FK_AB55E24FBE120E4E FOREIGN KEY (tournament_id_id) REFERENCES tournament (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT FK_AB55E24FC036E511 FOREIGN KEY (player_id_id) REFERENCES player (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_AB55E24FBE120E4E ON participation (tournament_id_id)');
        $this->addSql('CREATE INDEX IDX_AB55E24FC036E511 ON participation (player_id_id)');
    }
}
