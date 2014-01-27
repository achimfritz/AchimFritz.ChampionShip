<?php
namespace TYPO3\Flow\Persistence\Doctrine\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
	Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20140119171015 extends AbstractMigration {

	/**
	 * @param Schema $schema
	 * @return void
	 */
	public function up(Schema $schema) {
			// this up() migration is autogenerated, please modify it to your needs
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");
		$this->addSql("UPDATE achimfritz_championship_domain_model_cup set tippointspolicy='\AchimFritz\ChampionShip\Domain\Policy\TipPoints\TwoOnePolicy' where tippointspolicy='' ");
		$this->addSql("UPDATE achimfritz_championship_domain_model_cup set grouptablepolicy='\AchimFritz\ChampionShip\Domain\Policy\GroupTable\UefaPointEqualityPolicy' where grouptablepolicy=''");
		
	}

	/**
	 * @param Schema $schema
	 * @return void
	 */
	public function down(Schema $schema) {
			// this down() migration is autogenerated, please modify it to your needs
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");
		
	}
}

?>