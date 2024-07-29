<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240729135155 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_module_program (user_id INT NOT NULL, module_program_id INT NOT NULL, INDEX IDX_521396C4A76ED395 (user_id), INDEX IDX_521396C4AB5D2C97 (module_program_id), PRIMARY KEY(user_id, module_program_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_module_program ADD CONSTRAINT FK_521396C4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_module_program ADD CONSTRAINT FK_521396C4AB5D2C97 FOREIGN KEY (module_program_id) REFERENCES module_program (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE session ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_D044D5D4A76ED395 ON session (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_module_program DROP FOREIGN KEY FK_521396C4A76ED395');
        $this->addSql('ALTER TABLE user_module_program DROP FOREIGN KEY FK_521396C4AB5D2C97');
        $this->addSql('DROP TABLE user_module_program');
        $this->addSql('ALTER TABLE session DROP FOREIGN KEY FK_D044D5D4A76ED395');
        $this->addSql('DROP INDEX IDX_D044D5D4A76ED395 ON session');
        $this->addSql('ALTER TABLE session DROP user_id');
    }
}
