<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241013224238 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE article_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE client_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE details_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE dette_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE etat_article_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE etat_dette_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE type_dette_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE user_role_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE article (id INT NOT NULL, etat_id INT NOT NULL, reference VARCHAR(100) NOT NULL, libelle VARCHAR(100) NOT NULL, qte_stock DOUBLE PRECISION NOT NULL, prix DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_23A0E66D5E86FF ON article (etat_id)');
        $this->addSql('CREATE TABLE client (id INT NOT NULL, userr_id INT DEFAULT NULL, surname VARCHAR(100) NOT NULL, telephone VARCHAR(15) NOT NULL, adresse VARCHAR(255) NOT NULL, create_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, update_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, is_blocked BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C7440455450FF010 ON client (telephone)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C7440455DF0FD358 ON client (userr_id)');
        $this->addSql('COMMENT ON COLUMN client.create_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN client.update_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE details (id INT NOT NULL, article_id INT NOT NULL, dette_id INT NOT NULL, qte_dette DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_72260B8A7294869C ON details (article_id)');
        $this->addSql('CREATE INDEX IDX_72260B8AE11400A1 ON details (dette_id)');
        $this->addSql('CREATE TABLE dette (id INT NOT NULL, type_id INT NOT NULL, etat_id INT NOT NULL, client_id INT NOT NULL, montant DOUBLE PRECISION NOT NULL, montant_verse DOUBLE PRECISION NOT NULL, montant_restant DOUBLE PRECISION DEFAULT NULL, create_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, update_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_831BC808C54C8C93 ON dette (type_id)');
        $this->addSql('CREATE INDEX IDX_831BC808D5E86FF ON dette (etat_id)');
        $this->addSql('CREATE INDEX IDX_831BC80819EB6921 ON dette (client_id)');
        $this->addSql('COMMENT ON COLUMN dette.create_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN dette.update_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE etat_article (id INT NOT NULL, libelle VARCHAR(100) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE etat_dette (id INT NOT NULL, libelle VARCHAR(100) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE type_dette (id INT NOT NULL, libelle VARCHAR(100) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, role_id INT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, login VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, create_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, update_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, is_blocked BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649AA08CB10 ON "user" (login)');
        $this->addSql('CREATE INDEX IDX_8D93D649D60322AC ON "user" (role_id)');
        $this->addSql('COMMENT ON COLUMN "user".create_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN "user".update_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE user_role (id INT NOT NULL, libelle VARCHAR(100) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('COMMENT ON COLUMN messenger_messages.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.available_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.delivered_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66D5E86FF FOREIGN KEY (etat_id) REFERENCES etat_article (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455DF0FD358 FOREIGN KEY (userr_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE details ADD CONSTRAINT FK_72260B8A7294869C FOREIGN KEY (article_id) REFERENCES article (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE details ADD CONSTRAINT FK_72260B8AE11400A1 FOREIGN KEY (dette_id) REFERENCES dette (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE dette ADD CONSTRAINT FK_831BC808C54C8C93 FOREIGN KEY (type_id) REFERENCES type_dette (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE dette ADD CONSTRAINT FK_831BC808D5E86FF FOREIGN KEY (etat_id) REFERENCES etat_dette (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE dette ADD CONSTRAINT FK_831BC80819EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D649D60322AC FOREIGN KEY (role_id) REFERENCES user_role (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE article_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE client_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE details_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE dette_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE etat_article_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE etat_dette_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE type_dette_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE user_role_id_seq CASCADE');
        $this->addSql('ALTER TABLE article DROP CONSTRAINT FK_23A0E66D5E86FF');
        $this->addSql('ALTER TABLE client DROP CONSTRAINT FK_C7440455DF0FD358');
        $this->addSql('ALTER TABLE details DROP CONSTRAINT FK_72260B8A7294869C');
        $this->addSql('ALTER TABLE details DROP CONSTRAINT FK_72260B8AE11400A1');
        $this->addSql('ALTER TABLE dette DROP CONSTRAINT FK_831BC808C54C8C93');
        $this->addSql('ALTER TABLE dette DROP CONSTRAINT FK_831BC808D5E86FF');
        $this->addSql('ALTER TABLE dette DROP CONSTRAINT FK_831BC80819EB6921');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D649D60322AC');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE details');
        $this->addSql('DROP TABLE dette');
        $this->addSql('DROP TABLE etat_article');
        $this->addSql('DROP TABLE etat_dette');
        $this->addSql('DROP TABLE type_dette');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE user_role');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
