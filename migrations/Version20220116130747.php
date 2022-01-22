<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220116130747 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE details_commande_produit (details_commande_id INT NOT NULL, produit_id INT NOT NULL, INDEX IDX_59A49BBE99004AB (details_commande_id), INDEX IDX_59A49BBF347EFB (produit_id), PRIMARY KEY(details_commande_id, produit_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE details_commande_produit ADD CONSTRAINT FK_59A49BBE99004AB FOREIGN KEY (details_commande_id) REFERENCES details_commande (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE details_commande_produit ADD CONSTRAINT FK_59A49BBF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE details_commande ADD commande_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE details_commande ADD CONSTRAINT FK_4BCD5F682EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('CREATE INDEX IDX_4BCD5F682EA2E54 ON details_commande (commande_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE details_commande_produit');
        $this->addSql('ALTER TABLE details_commande DROP FOREIGN KEY FK_4BCD5F682EA2E54');
        $this->addSql('DROP INDEX IDX_4BCD5F682EA2E54 ON details_commande');
        $this->addSql('ALTER TABLE details_commande DROP commande_id');
    }
}
