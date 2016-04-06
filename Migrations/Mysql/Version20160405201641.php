<?php
namespace TYPO3\Flow\Persistence\Doctrine\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
	Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20160405201641 extends AbstractMigration {

	/**
	 * @param Schema $schema
	 * @return void
	 */
	public function up(Schema $schema) {
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");

		$this->addSql("RENAME TABLE achimfritz_championship_domain_model_round TO achimfritz_championship_competition_domain_model_round");

		$this->addSql("ALTER TABLE achimfritz_championship_domain_model_round_teams_join CHANGE championship_round competition_round VARCHAR(40) NOT NULL");
		$this->addSql("ALTER TABLE achimfritz_championship_domain_model_round_teams_join CHANGE championship_team competition_team VARCHAR(40) NOT NULL");
		$this->addSql("RENAME TABLE achimfritz_championship_domain_model_round_teams_join TO achimfritz_championship_competition_domain_mod_5fbbe_teams_join");

		$this->addSql("RENAME TABLE achimfritz_championship_domain_model_koround TO achimfritz_championship_competition_domain_model_koround");
		$this->addSql("RENAME TABLE achimfritz_championship_domain_model_childkoround TO achimfritz_championship_competition_domain_model_childkoround");
		$this->addSql("RENAME TABLE achimfritz_championship_domain_model_cup TO achimfritz_championship_competition_domain_model_cup");

		$this->addSql("ALTER TABLE achimfritz_championship_domain_model_cup_teams_join CHANGE championship_cup competition_cup VARCHAR(40) NOT NULL");
		$this->addSql("ALTER TABLE achimfritz_championship_domain_model_cup_teams_join CHANGE championship_team competition_team VARCHAR(40) NOT NULL");
		$this->addSql("RENAME TABLE achimfritz_championship_domain_model_cup_teams_join TO achimfritz_championship_competition_domain_model_cup_teams_join");
		$this->addSql("RENAME TABLE achimfritz_championship_domain_model_groupround TO achimfritz_championship_competition_domain_model_groupround");
		$this->addSql("RENAME TABLE achimfritz_championship_domain_model_grouptablerow TO achimfritz_championship_competition_domain_model_grouptablerow ");
		$this->addSql("RENAME TABLE achimfritz_championship_domain_model_result TO achimfritz_championship_competition_domain_model_result");
		$this->addSql("RENAME TABLE achimfritz_championship_domain_model_team TO achimfritz_championship_competition_domain_model_team");
		$this->addSql("RENAME TABLE achimfritz_championship_domain_model_match TO achimfritz_championship_competition_domain_model_match");
		$this->addSql("RENAME TABLE achimfritz_championship_domain_model_komatch TO achimfritz_championship_competition_domain_model_komatch");
		$this->addSql("RENAME TABLE achimfritz_championship_domain_model_crossgroupmatch TO achimfritz_championship_competition_domain_model_crossgro_ce83d");
		$this->addSql("RENAME TABLE achimfritz_championship_domain_model_groupmatch TO achimfritz_championship_competition_domain_model_groupmatch");
		$this->addSql("RENAME TABLE achimfritz_championship_domain_model_teamsoftwomatchesmatch TO achimfritz_championship_competition_domain_model_teamsoft_a6728");
	}

	/**
	 * @param Schema $schema
	 * @return void
	 */
	public function down(Schema $schema) {
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");
		$this->addSql("RENAME TABLE achimfritz_championship_competition_domain_model_round TO achimfritz_championship_domain_model_round");

		$this->addSql("ALTER TABLE achimfritz_championship_competition_domain_mod_5fbbe_teams_join CHANGE competition_round championship_round VARCHAR(40) NOT NULL");
		$this->addSql("ALTER TABLE achimfritz_championship_competition_domain_mod_5fbbe_teams_join CHANGE competition_team championship_team VARCHAR(40) NOT NULL");
		$this->addSql("RENAME TABLE achimfritz_championship_competition_domain_mod_5fbbe_teams_join TO achimfritz_championship_domain_model_round_teams_join");

		$this->addSql("RENAME TABLE achimfritz_championship_competition_domain_model_koround TO achimfritz_championship_domain_model_koround");
		$this->addSql("RENAME TABLE achimfritz_championship_competition_domain_model_childkoround TO achimfritz_championship_domain_model_childkoround");
		$this->addSql("RENAME TABLE achimfritz_championship_competition_domain_model_cup TO achimfritz_championship_domain_model_cup");

		$this->addSql("ALTER TABLE achimfritz_championship_competition_domain_model_cup_teams_join CHANGE competition_cup championship_cup VARCHAR(40) NOT NULL");
		$this->addSql("ALTER TABLE achimfritz_championship_competition_domain_model_cup_teams_join CHANGE competition_team championship_team VARCHAR(40) NOT NULL");
		$this->addSql("RENAME TABLE achimfritz_championship_competition_domain_model_cup_teams_join TO achimfritz_championship_domain_model_cup_teams_join");
		$this->addSql("RENAME TABLE achimfritz_championship_competition_domain_model_groupround TO achimfritz_championship_domain_model_groupround");
		$this->addSql("RENAME TABLE achimfritz_championship_competition_domain_model_grouptablerow TO achimfritz_championship_domain_model_grouptablerow ");
		$this->addSql("RENAME TABLE achimfritz_championship_competition_domain_model_result TO achimfritz_championship_domain_model_result");
		$this->addSql("RENAME TABLE achimfritz_championship_competition_domain_model_team TO achimfritz_championship_domain_model_team");
		$this->addSql("RENAME TABLE achimfritz_championship_competition_domain_model_match TO achimfritz_championship_domain_model_match");
		$this->addSql("RENAME TABLE achimfritz_championship_competition_domain_model_komatch TO achimfritz_championship_domain_model_komatch");
		$this->addSql("RENAME TABLE achimfritz_championship_competition_domain_model_crossgro_ce83d TO achimfritz_championship_domain_model_crossgroupmatch");
		$this->addSql("RENAME TABLE achimfritz_championship_competition_domain_model_groupmatch TO achimfritz_championship_domain_model_groupmatch");
		$this->addSql("RENAME TABLE achimfritz_championship_competition_domain_model_teamsoft_a6728 TO achimfritz_championship_domain_model_teamsoftwomatchesmatch");
	}
}