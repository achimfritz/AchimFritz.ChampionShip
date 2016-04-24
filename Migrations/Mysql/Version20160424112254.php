<?php
namespace TYPO3\Flow\Persistence\Doctrine\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
	Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20160424112254 extends AbstractMigration {

	/**
	 * @param Schema $schema
	 * @return void
	 */
	public function up(Schema $schema) {

		$this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");
		$this->addSql("RENAME TABLE achimfritz_championship_tip_domain_model_tipgroup TO achimfritz_championship_user_domain_model_tipgroup");
		$this->addSql("ALTER TABLE achimfritz_championship_user_domain_model_user_tipgroups_join CHANGE tip_tipgroup user_tipgroup VARCHAR(40) NOT NULL");
	}

	/**
	 * @param Schema $schema
	 * @return void
	 */
	public function down(Schema $schema) {
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");
		$this->addSql("RENAME TABLE achimfritz_championship_tip_domain_model_tipgroup TO achimfritz_championship_user_domain_model_tipgroup");
		$this->addSql("ALTER TABLE achimfritz_championship_user_domain_model_user_tipgroups_join CHANGE user_tipgroup tip_tipgroup VARCHAR(40) NOT NULL");

	}
}