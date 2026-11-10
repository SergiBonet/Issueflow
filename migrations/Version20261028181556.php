<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261028181556 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categories (id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, name VARCHAR(120) NOT NULL, UNIQUE INDEX UNIQ_3AF346685E237E06 (name), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE users (id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, name VARCHAR(120) NOT NULL, email VARCHAR(120) NOT NULL, created_at DATE NOT NULL, UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE tickets ADD assigne_id BIGINT UNSIGNED DEFAULT NULL, ADD category_id BIGINT UNSIGNED DEFAULT NULL');
        $this->addSql('ALTER TABLE tickets ADD CONSTRAINT FK_54469DF48E7B8AB0 FOREIGN KEY (assigne_id) REFERENCES users (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE tickets ADD CONSTRAINT FK_54469DF412469DE2 FOREIGN KEY (category_id) REFERENCES categories (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_54469DF48E7B8AB0 ON tickets (assigne_id)');
        $this->addSql('CREATE INDEX IDX_54469DF412469DE2 ON tickets (category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE users');
        $this->addSql('ALTER TABLE tickets DROP FOREIGN KEY FK_54469DF48E7B8AB0');
        $this->addSql('ALTER TABLE tickets DROP FOREIGN KEY FK_54469DF412469DE2');
        $this->addSql('DROP INDEX IDX_54469DF48E7B8AB0 ON tickets');
        $this->addSql('DROP INDEX IDX_54469DF412469DE2 ON tickets');
        $this->addSql('ALTER TABLE tickets DROP assigne_id, DROP category_id');
    }
}
