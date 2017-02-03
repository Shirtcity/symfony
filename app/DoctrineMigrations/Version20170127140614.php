<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170127140614 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE manufacturer_image DROP FOREIGN KEY FK_CE63904F4584665A');
        $this->addSql('ALTER TABLE purchasable DROP FOREIGN KEY FK_FC2E9BFEA23B42D');
        $this->addSql('DROP TABLE manufacturer');
        $this->addSql('DROP TABLE manufacturer_image');
        $this->addSql('DROP INDEX IDX_FC2E9BFEA23B42D ON purchasable');
        $this->addSql('ALTER TABLE purchasable DROP manufacturer_id');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE manufacturer (id INT AUTO_INCREMENT NOT NULL, principal_image_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, slug VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, description LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, images_sort VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, meta_title VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, meta_description VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, meta_keywords VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, enabled TINYINT(1) NOT NULL, INDEX IDX_3D0AE6DCA7F1F96B (principal_image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE manufacturer_image (article_id INT NOT NULL, image_id INT NOT NULL, INDEX IDX_CE63904F7294869C (article_id), INDEX IDX_CE63904F3DA5256D (image_id), PRIMARY KEY(article_id, image_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE manufacturer ADD CONSTRAINT FK_3D0AE6DCA7F1F96B FOREIGN KEY (principal_image_id) REFERENCES image (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE manufacturer_image ADD CONSTRAINT FK_CE63904F3DA5256D FOREIGN KEY (image_id) REFERENCES image (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE manufacturer_image ADD CONSTRAINT FK_CE63904F4584665A FOREIGN KEY (article_id) REFERENCES manufacturer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE purchasable ADD manufacturer_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE purchasable ADD CONSTRAINT FK_FC2E9BFEA23B42D FOREIGN KEY (manufacturer_id) REFERENCES manufacturer (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_FC2E9BFEA23B42D ON purchasable (manufacturer_id)');
    }
}
