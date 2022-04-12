<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;


final class Version20220319224144 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE books DROP author');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE books ADD author VARCHAR(255) NOT NULL');
    }
}
