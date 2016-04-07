<?php
namespace TYPO3\Flow\Persistence\Doctrine\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
	Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20160407173421 extends AbstractMigration {

	/**
	 * @param Schema $schema
	 * @return void
	 */
	public function up(Schema $schema) {
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");
		$this->addSql("UPDATE achimfritz_championship_competition_domain_model_match SET dtype='achimfritz_championship_competition_groupmatch' WHERE dtype='achimfritz_championship_groupmatch'");
		$this->addSql("UPDATE achimfritz_championship_competition_domain_model_match SET dtype='achimfritz_championship_competition_komatch' WHERE dtype='achimfritz_championship_komatch'");
		$this->addSql("UPDATE achimfritz_championship_competition_domain_model_match SET dtype='achimfritz_championship_competition_teamsoftwomatchesmatch' WHERE dtype='achimfritz_championship_teamsoftwomatchesmatch'");
		$this->addSql("UPDATE achimfritz_championship_competition_domain_model_match SET dtype='achimfritz_championship_competition_crossgroupmatch' WHERE dtype='achimfritz_championship_crossgroupmatch'");
		$this->addSql("UPDATE achimfritz_championship_competition_domain_model_round SET dtype='achimfritz_championship_competition_groupround' WHERE dtype='achimfritz_championship_groupround'");
		$this->addSql("UPDATE achimfritz_championship_competition_domain_model_round SET dtype='achimfritz_championship_competition_childkoround' WHERE dtype='achimfritz_championship_childkoround'");
		$this->addSql("UPDATE achimfritz_championship_competition_domain_model_round SET dtype='achimfritz_championship_competition_koround' WHERE dtype='achimfritz_championship_koround'");
	}

	/**
	 * @param Schema $schema
	 * @return void
	 */
	public function down(Schema $schema) {
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");
		$this->addSql("UPDATE achimfritz_championship_competition_domain_model_match SET dtype='achimfritz_championship_groupmatch' WHERE dtype='achimfritz_championship_competition_groupmatch'");
		$this->addSql("UPDATE achimfritz_championship_competition_domain_model_match SET dtype='achimfritz_championship_komatch' WHERE dtype='achimfritz_championship_competition_komatch'");
		$this->addSql("UPDATE achimfritz_championship_competition_domain_model_match SET dtype='achimfritz_championship_teamsoftwomatchesmatch' WHERE dtype='achimfritz_championship_competition_teamsoftwomatchesmatch'");
		$this->addSql("UPDATE achimfritz_championship_competition_domain_model_match SET dtype='achimfritz_championship_crossgroupmatch' WHERE dtype='achimfritz_championship_competition_crossgroupmatch'");
		$this->addSql("UPDATE achimfritz_championship_competition_domain_model_round SET dtype='achimfritz_championship_groupround' WHERE dtype='achimfritz_championship_competition_groupround'");
		$this->addSql("UPDATE achimfritz_championship_competition_domain_model_round SET dtype='achimfritz_championship_childkoround' WHERE dtype='achimfritz_championship_competition_childkoround'");
		$this->addSql("UPDATE achimfritz_championship_competition_domain_model_round SET dtype='achimfritz_championship_koround' WHERE dtype='achimfritz_championship_competition_koround'");
	}
}