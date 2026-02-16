<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260216132113 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE film ADD poster VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE film_platforme ADD CONSTRAINT FK_D7996D81567F5183 FOREIGN KEY (film_id) REFERENCES film (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE film_platforme ADD CONSTRAINT FK_D7996D814FF12FE6 FOREIGN KEY (platforme_id) REFERENCES platforme (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE film DROP poster');
        $this->addSql('ALTER TABLE film_platforme DROP FOREIGN KEY FK_D7996D81567F5183');
        $this->addSql('ALTER TABLE film_platforme DROP FOREIGN KEY FK_D7996D814FF12FE6');
    }
}
