<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220116132202 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE details_commande_produit');
        $this->addSql('ALTER TABLE produit ADD details_commande_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27E99004AB FOREIGN KEY (details_commande_id) REFERENCES details_commande (id)');
        $this->addSql('CREATE INDEX IDX_29A5EC27E99004AB ON produit (details_commande_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE details_commande_produit (details_commande_id INT NOT NULL, produit_id INT NOT NULL, INDEX IDX_59A49BBE99004AB (details_commande_id), INDEX IDX_59A49BBF347EFB (produit_id), PRIMARY KEY(details_commande_id, produit_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE details_commande_produit ADD CONSTRAINT FK_59A49BBE99004AB FOREIGN KEY (details_commande_id) REFERENCES details_commande (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE details_commande_produit ADD CONSTRAINT FK_59A49BBF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27E99004AB');
        $this->addSql('DROP INDEX IDX_29A5EC27E99004AB ON produit');
        $this->addSql('ALTER TABLE produit DROP details_commande_id');
    }
}
