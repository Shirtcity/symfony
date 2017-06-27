<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170529073440 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE article_to_section_category (purchasable_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_5A6F2DD99778C508 (purchasable_id), INDEX IDX_5A6F2DD912469DE2 (category_id), PRIMARY KEY(purchasable_id, category_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE designs_countries (design_id INT NOT NULL, location_id VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, INDEX IDX_99E36475E41DC9B2 (design_id), INDEX IDX_99E3647564D218E (location_id), PRIMARY KEY(design_id, location_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE designs_foilcolors (design_id INT NOT NULL, foil_color_id INT NOT NULL, INDEX IDX_C4AB7260E41DC9B2 (design_id), INDEX IDX_C4AB7260A9F5B240 (foil_color_id), PRIMARY KEY(design_id, foil_color_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE foilColor (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(7) NOT NULL COLLATE utf8_unicode_ci, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, enabled TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE manufacturer (id INT AUTO_INCREMENT NOT NULL, principal_image_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, slug VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, description LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, images_sort VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, meta_title VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, meta_description VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, meta_keywords VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, enabled TINYINT(1) NOT NULL, INDEX IDX_3D0AE6DCA7F1F96B (principal_image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE manufacturer_image (article_id INT NOT NULL, image_id INT NOT NULL, INDEX IDX_CE63904F4584665A (article_id), INDEX IDX_CE63904F3DA5256D (image_id), PRIMARY KEY(article_id, image_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payment_state_lines (order_id INT NOT NULL, state_line_id INT NOT NULL, INDEX IDX_CB1ED8408D9F6D38 (order_id), INDEX IDX_CB1ED840B1B0FE4 (state_line_id), PRIMARY KEY(order_id, state_line_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE purchasable_category (purchasable_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_F98077AD9778C508 (purchasable_id), INDEX IDX_F98077AD12469DE2 (category_id), PRIMARY KEY(purchasable_id, category_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE purchasable_to_image (article_id INT NOT NULL, image_id INT NOT NULL, INDEX IDX_31CD5B037294869C (article_id), INDEX IDX_31CD5B033DA5256D (image_id), PRIMARY KEY(article_id, image_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE variant (id INT NOT NULL, article_id INT NOT NULL, INDEX IDX_F143BFAD4584665A (article_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE variant_options (variant_id INT NOT NULL, option_id INT NOT NULL, INDEX IDX_BF90D7C13B69A9AF (variant_id), INDEX IDX_BF90D7C1A7C41D6F (option_id), PRIMARY KEY(variant_id, option_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article_to_section_category ADD CONSTRAINT FK_817538EE12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article_to_section_category ADD CONSTRAINT FK_817538EE9778C508 FOREIGN KEY (purchasable_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE designs_countries ADD CONSTRAINT FK_99E3647564D218E FOREIGN KEY (location_id) REFERENCES location (id)');
        $this->addSql('ALTER TABLE designs_countries ADD CONSTRAINT FK_99E36475E41DC9B2 FOREIGN KEY (design_id) REFERENCES design (id)');
        $this->addSql('ALTER TABLE designs_foilcolors ADD CONSTRAINT FK_C4AB7260A9F5B240 FOREIGN KEY (foil_color_id) REFERENCES foil_color (id)');
        $this->addSql('ALTER TABLE designs_foilcolors ADD CONSTRAINT FK_C4AB7260E41DC9B2 FOREIGN KEY (design_id) REFERENCES design (id)');
        $this->addSql('ALTER TABLE manufacturer ADD CONSTRAINT FK_3D0AE6DCA7F1F96B FOREIGN KEY (principal_image_id) REFERENCES image (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE manufacturer_image ADD CONSTRAINT FK_CE63904F3DA5256D FOREIGN KEY (image_id) REFERENCES image (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE manufacturer_image ADD CONSTRAINT FK_CE63904F4584665A FOREIGN KEY (article_id) REFERENCES manufacturer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE payment_state_lines ADD CONSTRAINT FK_CB1ED8408D9F6D38 FOREIGN KEY (order_id) REFERENCES orders (id)');
        $this->addSql('ALTER TABLE payment_state_lines ADD CONSTRAINT FK_CB1ED840B1B0FE4 FOREIGN KEY (state_line_id) REFERENCES state_line (id)');
        $this->addSql('ALTER TABLE purchasable_category ADD CONSTRAINT FK_F98077AD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE purchasable_category ADD CONSTRAINT FK_F98077AD9778C508 FOREIGN KEY (purchasable_id) REFERENCES purchasable (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE purchasable_to_image ADD CONSTRAINT FK_31CD5B033DA5256D FOREIGN KEY (image_id) REFERENCES image (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE purchasable_to_image ADD CONSTRAINT FK_31CD5B037294869C FOREIGN KEY (article_id) REFERENCES purchasable (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE variant ADD CONSTRAINT FK_F143BFAD4584665A FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE variant ADD CONSTRAINT FK_F143BFADBF396750 FOREIGN KEY (id) REFERENCES purchasable (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE variant_options ADD CONSTRAINT FK_BF90D7C1A7C41D6F FOREIGN KEY (option_id) REFERENCES value (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE state_line DROP FOREIGN KEY FK_45F73D305D83CC1');
        $this->addSql('DROP INDEX IDX_45F73D305D83CC1 ON state_line');
    }
}
