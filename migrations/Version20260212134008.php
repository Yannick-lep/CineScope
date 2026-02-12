<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260212134008 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE film (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, synopsis LONGTEXT DEFAULT NULL, release_year INT NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE film_platforme (film_id INT NOT NULL, platforme_id INT NOT NULL, INDEX IDX_D7996D81567F5183 (film_id), INDEX IDX_D7996D814FF12FE6 (platforme_id), PRIMARY KEY (film_id, platforme_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE platforme (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, logo VARCHAR(255) DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE film_platforme ADD CONSTRAINT FK_D7996D81567F5183 FOREIGN KEY (film_id) REFERENCES film (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE film_platforme ADD CONSTRAINT FK_D7996D814FF12FE6 FOREIGN KEY (platforme_id) REFERENCES platforme (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE film_platforme DROP FOREIGN KEY FK_D7996D81567F5183');
        $this->addSql('ALTER TABLE film_platforme DROP FOREIGN KEY FK_D7996D814FF12FE6');
        $this->addSql('DROP TABLE film');
        $this->addSql('DROP TABLE film_platforme');
        $this->addSql('DROP TABLE platforme');
    }
}
