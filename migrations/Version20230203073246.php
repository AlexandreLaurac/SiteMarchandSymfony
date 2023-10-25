<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230203073246 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE ligne_commande_id_seq CASCADE');
        $this->addSql('DROP INDEX "primary"');
        $this->addSql('ALTER TABLE ligne_commande DROP id');
        $this->addSql('ALTER TABLE ligne_commande ADD PRIMARY KEY (commande_id, produit_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE ligne_commande_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('DROP INDEX ligne_commande_pkey');
        $this->addSql('ALTER TABLE ligne_commande ADD id INT NOT NULL');
        $this->addSql('ALTER TABLE ligne_commande ADD PRIMARY KEY (id)');
    }
}
