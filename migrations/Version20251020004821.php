<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251020004821 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book_reader DROP FOREIGN KEY FK_E5E882B116A2B381');
        $this->addSql('ALTER TABLE book_reader DROP FOREIGN KEY FK_E5E882B11717D737');
        $this->addSql('DROP TABLE book_reader');
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A331A52622F');
        $this->addSql('DROP INDEX IDX_CBE5A331A52622F ON book');
        $this->addSql('ALTER TABLE book DROP authorbook_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE book_reader (book_id INT NOT NULL, reader_id INT NOT NULL, INDEX IDX_E5E882B11717D737 (reader_id), INDEX IDX_E5E882B116A2B381 (book_id), PRIMARY KEY(book_id, reader_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE book_reader ADD CONSTRAINT FK_E5E882B116A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE book_reader ADD CONSTRAINT FK_E5E882B11717D737 FOREIGN KEY (reader_id) REFERENCES reader (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE book ADD authorbook_id INT NOT NULL');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A331A52622F FOREIGN KEY (authorbook_id) REFERENCES author (id)');
        $this->addSql('CREATE INDEX IDX_CBE5A331A52622F ON book (authorbook_id)');
    }
}
