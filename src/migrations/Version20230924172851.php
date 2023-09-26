<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230924172851 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'ser default values';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('INSERT INTO question (text) VALUES (\'1 + 1 = \'), (\'2 + 2 = \'), (\'3 + 3 = \'), (\'4 + 4 = \'), (\'5 + 5 = \'), (\'6 + 6 = \'), (\'7 + 7 = \'), (\'8 + 8 = \'), (\'9 + 9 = \'), (\'10 + 10 = \')');
        $this->addSql('INSERT INTO answer (question_id, variant, correct) VALUES (1, \'3\', false), (1, \'2\', true), (1, \'1\', false)');
        $this->addSql('INSERT INTO answer (question_id, variant, correct) VALUES (2, \'4\', true), (2, \'3 + 1 \', true), (2, \'10\', false)');
        $this->addSql('INSERT INTO answer (question_id, variant, correct) VALUES (3, \'1 + 5\', true), (3, \'1\', false), (3, \'6\', true), (3, \'2 + 4\', true)');
        $this->addSql('INSERT INTO answer (question_id, variant, correct) VALUES (4, \'8\', true), (4, \'4\', false), (4, \'0\', false), (4, \'0 + 8\', true)');
        $this->addSql('INSERT INTO answer (question_id, variant, correct) VALUES (5, \'6\', false), (5, \'18\', false), (5, \'10\', true), (5, \'9\', false), (5, \'0\', false)');
        $this->addSql('INSERT INTO answer (question_id, variant, correct) VALUES (6, \'3\', false), (6, \'9\', false), (6, \'0\', false), (6, \'12\', true), (6, \'5 + 7\', true)');
        $this->addSql('INSERT INTO answer (question_id, variant, correct) VALUES (7, \'5\', false), (7, \'14\', true)');
        $this->addSql('INSERT INTO answer (question_id, variant, correct) VALUES (8, \'16\', true), (8, \'12\', false), (8, \'9\', false), (8, \'5\', false)');
        $this->addSql('INSERT INTO answer (question_id, variant, correct) VALUES (9, \'18\', true), (9, \'9\', false), (9, \'17 + 1\', true), (9, \'2 + 16\', true)');
        $this->addSql('INSERT INTO answer (question_id, variant, correct) VALUES (10, \'0\', false), (10, \'2\', false), (10, \'8\', false), (10, \'20\', true)');

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('TRUNCATE answer');
        $this->addSql('TRUNCATE question');
    }
}
