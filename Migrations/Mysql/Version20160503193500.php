<?php
namespace Neos\Flow\Persistence\Doctrine\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
	Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20160503193500 extends AbstractMigration {

	/**
	 * @var array
	 */
	protected $cups = array();

	/**
	 * @var array
	 */
	protected $tipCups = array();

	/**
	 * @param Schema $schema
	 * @return void
	 * @throws \Doctrine\DBAL\DBALException
	 */
	public function preUp(Schema $schema) {
		$query = "SELECT * FROM achimfritz_championship_competition_domain_model_cup";
		$stmt = $this->connection->prepare($query);
		$stmt->execute();
		while ($row = $stmt->fetch()) {
			$this->cups[] = $row;
		}
	}

	/**
	 * @param Schema $schema
	 * @return void
	 */
	public function up(Schema $schema) {
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");
		$this->addSql("CREATE TABLE achimfritz_championship_tip_domain_model_tipcup (persistence_object_identifier VARCHAR(40) NOT NULL, cup VARCHAR(40) DEFAULT NULL, tippointspolicy VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_21893F0AB79D50E4 (cup), PRIMARY KEY(persistence_object_identifier)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
		$this->addSql("ALTER TABLE achimfritz_championship_tip_domain_model_tipcup ADD CONSTRAINT FK_21893F0AB79D50E4 FOREIGN KEY (cup) REFERENCES achimfritz_championship_competition_domain_model_cup (persistence_object_identifier)");
		$this->addSql("ALTER TABLE achimfritz_championship_competition_domain_model_cup DROP tippointspolicy");
	}

	/**
	 * @param Schema $schema
	 * @return void
	 * @throws \Doctrine\DBAL\DBALException
	 */
	public function postUp(Schema $schema) {
		foreach ($this->cups as $row) {
			$sql = 'SELECT ' . $this->connection->getDatabasePlatform()->getGuidExpression();
			$identifier =  $this->connection->query($sql)->fetchColumn(0);
			$tipCupRow = array(
				'persistence_object_identifier' => $identifier,
				'cup' => $row['persistence_object_identifier'],
				'tippointspolicy' => $row['tippointspolicy']
			);
			$this->connection->insert('achimfritz_championship_tip_domain_model_tipcup', $tipCupRow);
		}
	}

	/**
	 * @param Schema $schema
	 * @return void
	 * @throws \Doctrine\DBAL\DBALException
	 */
	public function preDown(Schema $schema) {
		$query = "SELECT * FROM achimfritz_championship_tip_domain_model_tipcup";
		$stmt = $this->connection->prepare($query);
		$stmt->execute();
		while ($row = $stmt->fetch()) {
			$this->tipCups[] = $row;
		}
	}

	/**
	 * @param Schema $schema
	 * @return void
	 */
	public function down(Schema $schema) {
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");
		$this->addSql("DROP TABLE achimfritz_championship_tip_domain_model_tipcup");
		$this->addSql("ALTER TABLE achimfritz_championship_competition_domain_model_cup ADD tippointspolicy VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci");
	}

	/**
	 * @param Schema $schema
	 * @return void
	 * @throws \Doctrine\DBAL\DBALException
	 */
	public function postDown(Schema $schema) {
		foreach ($this->tipCups as $row) {
			$this->connection->update(
				'achimfritz_championship_competition_domain_model_cup',
				array('tippointspolicy' => $row['tippointspolicy']),
				array('persistence_object_identifier' => $row['cup'])
			);
		}
	}

}