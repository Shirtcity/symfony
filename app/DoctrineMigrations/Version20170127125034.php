<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170127125034 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE pack_purchasable DROP FOREIGN KEY FK_8D846271919B217');
        $this->addSql('ALTER TABLE variant_options DROP FOREIGN KEY FK_BF90D7C13B69A9AF');
        $this->addSql('DROP TABLE pack');
        $this->addSql('DROP TABLE pack_purchasable');
        $this->addSql('DROP TABLE product_variant');
        $this->addSql('DROP TABLE variant');
        $this->addSql('DROP TABLE variant_options');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE pack (id INT NOT NULL, stock_type INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pack_purchasable (pack_id INT NOT NULL, purchasable_id INT NOT NULL, INDEX IDX_8D846271919B217 (pack_id), INDEX IDX_8D846279778C508 (purchasable_id), PRIMARY KEY(pack_id, purchasable_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_variant (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, size_id INT NOT NULL, color_id INT NOT NULL, active TINYINT(1) NOT NULL, INDEX IDX_209AA41D4584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE variant (id INT NOT NULL, article_id INT NOT NULL, INDEX IDX_F143BFAD7294869C (article_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE variant_options (variant_id INT NOT NULL, option_id INT NOT NULL, INDEX IDX_BF90D7C13B69A9AF (variant_id), INDEX IDX_BF90D7C1A7C41D6F (option_id), PRIMARY KEY(variant_id, option_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pack ADD CONSTRAINT FK_97DE5E23BF396750 FOREIGN KEY (id) REFERENCES purchasable (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pack_purchasable ADD CONSTRAINT FK_8D846271919B217 FOREIGN KEY (pack_id) REFERENCES pack (id)');
        $this->addSql('ALTER TABLE pack_purchasable ADD CONSTRAINT FK_8D846279778C508 FOREIGN KEY (purchasable_id) REFERENCES purchasable (id)');
        $this->addSql('ALTER TABLE product_variant ADD CONSTRAINT FK_209AA41D4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE variant ADD CONSTRAINT FK_F143BFAD4584665A FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE variant ADD CONSTRAINT FK_F143BFADBF396750 FOREIGN KEY (id) REFERENCES purchasable (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE variant_options ADD CONSTRAINT FK_BF90D7C13B69A9AF FOREIGN KEY (variant_id) REFERENCES variant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE variant_options ADD CONSTRAINT FK_BF90D7C1A7C41D6F FOREIGN KEY (option_id) REFERENCES value (id) ON DELETE CASCADE');
    }
}
