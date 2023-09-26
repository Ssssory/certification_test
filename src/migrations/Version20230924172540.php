<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230924172540 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE question (id SERIAL PRIMARY KEY, text TEXT NOT NULL)');
        $this->addSql('CREATE TABLE answer (id SERIAL PRIMARY KEY, question_id INT REFERENCES question(id), variant VARCHAR(255) NOT NULL, correct BOOLEAN NOT NULL)');
        $this->addSql('CREATE TABLE exam (id SERIAL PRIMARY KEY, name VARCHAR(255) NOT NULL, date_start TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, complete BOOLEAN NOT NULL)');
        $this->addSql('CREATE TABLE history (id SERIAL PRIMARY KEY, exam_id INT REFERENCES exam(id), question_id INT REFERENCES question(id), answer_id INT REFERENCES answer(id), step INT NOT NULL)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE answer');
        $this->addSql('DROP TABLE exam');
        $this->addSql('DROP TABLE history');
        $this->addSql('DROP TABLE question');
    }
}
