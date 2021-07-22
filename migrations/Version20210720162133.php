<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210720162133 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, morceau_id_id INT DEFAULT NULL, user_id_id INT NOT NULL, commentaire LONGTEXT DEFAULT NULL, date DATETIME NOT NULL, INDEX IDX_67F068BC70A813B0 (morceau_id_id), INDEX IDX_67F068BC9D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE morceau (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, artiste VARCHAR(255) NOT NULL, lien_spotify VARCHAR(255) NOT NULL, date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE proposition (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, titre VARCHAR(255) NOT NULL, artiste VARCHAR(255) NOT NULL, lien_spotify VARCHAR(255) DEFAULT NULL, date DATETIME NOT NULL, INDEX IDX_C7CDC3539D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, role VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, pseudo VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vote (id INT AUTO_INCREMENT NOT NULL, morceau_id_id INT NOT NULL, user_id_id INT NOT NULL, INDEX IDX_5A10856470A813B0 (morceau_id_id), INDEX IDX_5A1085649D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC70A813B0 FOREIGN KEY (morceau_id_id) REFERENCES morceau (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE proposition ADD CONSTRAINT FK_C7CDC3539D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A10856470A813B0 FOREIGN KEY (morceau_id_id) REFERENCES morceau (id)');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A1085649D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC70A813B0');
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A10856470A813B0');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC9D86650F');
        $this->addSql('ALTER TABLE proposition DROP FOREIGN KEY FK_C7CDC3539D86650F');
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A1085649D86650F');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE morceau');
        $this->addSql('DROP TABLE proposition');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE vote');
    }
}
