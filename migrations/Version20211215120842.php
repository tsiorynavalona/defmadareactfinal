<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211215120842 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE blog_post_category_post (blog_post_id INT NOT NULL, category_post_id INT NOT NULL, INDEX IDX_6AF871F0A77FBEAF (blog_post_id), INDEX IDX_6AF871F08C514352 (category_post_id), PRIMARY KEY(blog_post_id, category_post_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE blog_post_category_post ADD CONSTRAINT FK_6AF871F0A77FBEAF FOREIGN KEY (blog_post_id) REFERENCES blog_post (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE blog_post_category_post ADD CONSTRAINT FK_6AF871F08C514352 FOREIGN KEY (category_post_id) REFERENCES category_post (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE blog_post ADD image_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE blog_post ADD CONSTRAINT FK_BA5AE01D3DA5256D FOREIGN KEY (image_id) REFERENCES image_post (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BA5AE01D3DA5256D ON blog_post (image_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE blog_post_category_post');
        $this->addSql('ALTER TABLE blog_post DROP FOREIGN KEY FK_BA5AE01D3DA5256D');
        $this->addSql('DROP INDEX UNIQ_BA5AE01D3DA5256D ON blog_post');
        $this->addSql('ALTER TABLE blog_post DROP image_id');
    }
}
