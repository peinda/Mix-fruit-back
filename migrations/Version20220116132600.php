<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220116132600 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE details_commande ADD produit_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE details_commande ADD CONSTRAINT FK_4BCD5F6F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('CREATE INDEX IDX_4BCD5F6F347EFB ON details_commande (produit_id)');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27E99004AB');
        $this->addSql('DROP INDEX IDX_29A5EC27E99004AB ON produit');
        $this->addSql('ALTER TABLE produit DROP details_commande_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE details_commande DROP FOREIGN KEY FK_4BCD5F6F347EFB');
        $this->addSql('DROP INDEX IDX_4BCD5F6F347EFB ON details_commande');
        $this->addSql('ALTER TABLE details_commande DROP produit_id');
        $this->addSql('ALTER TABLE produit ADD details_commande_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27E99004AB FOREIGN KEY (details_commande_id) REFERENCES details_commande (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_29A5EC27E99004AB ON produit (details_commande_id)');
    }
}
