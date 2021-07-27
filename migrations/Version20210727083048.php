<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210727083048 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC70A813B0');
        $this->addSql('DROP INDEX IDX_67F068BC70A813B0 ON commentaire');
        $this->addSql('ALTER TABLE commentaire CHANGE morceau_id_id lemorceau_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCBD6C5024 FOREIGN KEY (lemorceau_id) REFERENCES morceau (id)');
        $this->addSql('CREATE INDEX IDX_67F068BCBD6C5024 ON commentaire (lemorceau_id)');
        $this->addSql('ALTER TABLE proposition CHANGE user_id user_id INT DEFAULT NULL, CHANGE date date DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A10856470A813B0');
        $this->addSql('DROP INDEX IDX_5A10856470A813B0 ON vote');
        $this->addSql('ALTER TABLE vote ADD lemorceau_id INT DEFAULT NULL, DROP morceau_id_id');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A108564BD6C5024 FOREIGN KEY (lemorceau_id) REFERENCES morceau (id)');
        $this->addSql('CREATE INDEX IDX_5A108564BD6C5024 ON vote (lemorceau_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCBD6C5024');
        $this->addSql('DROP INDEX IDX_67F068BCBD6C5024 ON commentaire');
        $this->addSql('ALTER TABLE commentaire CHANGE lemorceau_id morceau_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC70A813B0 FOREIGN KEY (morceau_id_id) REFERENCES morceau (id)');
        $this->addSql('CREATE INDEX IDX_67F068BC70A813B0 ON commentaire (morceau_id_id)');
        $this->addSql('ALTER TABLE proposition CHANGE user_id user_id INT NOT NULL, CHANGE date date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A108564BD6C5024');
        $this->addSql('DROP INDEX IDX_5A108564BD6C5024 ON vote');
        $this->addSql('ALTER TABLE vote ADD morceau_id_id INT NOT NULL, DROP lemorceau_id');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A10856470A813B0 FOREIGN KEY (morceau_id_id) REFERENCES morceau (id)');
        $this->addSql('CREATE INDEX IDX_5A10856470A813B0 ON vote (morceau_id_id)');
    }
}
