<?php
namespace Neos\Flow\Persistence\Doctrine\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
	Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20160410170145 extends AbstractMigration {

	/**
	 * @param Schema $schema
	 * @return void
	 */
	public function up(Schema $schema) {
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");

		$this->addSql("RENAME TABLE achimfritz_championship_domain_model_chatentry TO achimfritz_championship_chat_domain_model_chatentry");
		$this->addSql("RENAME TABLE achimfritz_championship_domain_model_contactrequest TO achimfritz_championship_user_domain_model_contactrequest");
		$this->addSql("RENAME TABLE achimfritz_championship_domain_model_openchatentry TO achimfritz_championship_chat_domain_model_openchatentry");
		$this->addSql("RENAME TABLE achimfritz_championship_domain_model_password TO achimfritz_championship_user_domain_model_password");
		$this->addSql("RENAME TABLE achimfritz_championship_domain_model_ranking TO achimfritz_championship_tip_domain_model_ranking");
		$this->addSql("RENAME TABLE achimfritz_championship_domain_model_registrationrequest TO achimfritz_championship_user_domain_model_registrationrequest");
		$this->addSql("RENAME TABLE achimfritz_championship_domain_model_tip TO achimfritz_championship_tip_domain_model_tip");
		$this->addSql("RENAME TABLE achimfritz_championship_domain_model_tipgroup TO achimfritz_championship_tip_domain_model_tipgroup");
		$this->addSql("RENAME TABLE achimfritz_championship_domain_model_tipgroupchatentry TO achimfritz_championship_chat_domain_model_tipgroupchatentry");
		$this->addSql("RENAME TABLE achimfritz_championship_domain_model_tipgroupr_95a10_users_join TO achimfritz_championship_tip_domain_model_tipgr_c2a81_users_join");
		$this->addSql("RENAME TABLE achimfritz_championship_domain_model_tipgroupre_95a10_rows_join TO achimfritz_championship_tip_domain_model_tipgro_c2a81_rows_join");
		$this->addSql("RENAME TABLE achimfritz_championship_domain_model_tipgroupre_edab4_tips_join TO achimfritz_championship_tip_domain_model_tipgro_d24a5_tips_join");
		$this->addSql("RENAME TABLE achimfritz_championship_domain_model_tipgroupresultmatrix TO achimfritz_championship_tip_domain_model_tipgroupresultmatrix");
		$this->addSql("RENAME TABLE achimfritz_championship_domain_model_tipgroupresultmatrixrow TO achimfritz_championship_tip_domain_model_tipgroupresultma_d24a5");
		$this->addSql("RENAME TABLE achimfritz_championship_domain_model_user TO achimfritz_championship_user_domain_model_user");
		$this->addSql("RENAME TABLE achimfritz_championship_domain_model_user_tipgroups_join TO achimfritz_championship_user_domain_model_user_tipgroups_join");

		$this->addSql("ALTER TABLE achimfritz_championship_tip_domain_model_tipgr_c2a81_users_join CHANGE championship_tipgroupresultmatrix tip_tipgroupresultmatrix VARCHAR(40) NOT NULL");
		$this->addSql("ALTER TABLE achimfritz_championship_tip_domain_model_tipgr_c2a81_users_join CHANGE championship_user user_user VARCHAR(40) NOT NULL");
		$this->addSql("ALTER TABLE achimfritz_championship_tip_domain_model_tipgro_c2a81_rows_join CHANGE championship_tipgroupresultmatrix tip_tipgroupresultmatrix VARCHAR(40) NOT NULL");
		$this->addSql("ALTER TABLE achimfritz_championship_tip_domain_model_tipgro_c2a81_rows_join CHANGE championship_tipgroupresultmatrixrow tip_tipgroupresultmatrixrow VARCHAR(40) NOT NULL");
		$this->addSql("ALTER TABLE achimfritz_championship_tip_domain_model_tipgro_d24a5_tips_join CHANGE championship_tipgroupresultmatrixrow tip_tipgroupresultmatrixrow VARCHAR(40) NOT NULL");
		$this->addSql("ALTER TABLE achimfritz_championship_tip_domain_model_tipgro_d24a5_tips_join CHANGE championship_tip tip_tip VARCHAR(40) NOT NULL");
		$this->addSql("ALTER TABLE achimfritz_championship_user_domain_model_user_tipgroups_join CHANGE championship_user user_user VARCHAR(40) NOT NULL");
		$this->addSql("ALTER TABLE achimfritz_championship_user_domain_model_user_tipgroups_join CHANGE championship_tipgroup tip_tipgroup VARCHAR(40) NOT NULL");

		$this->addSql("UPDATE achimfritz_championship_chat_domain_model_chatentry SET dtype='achimfritz_championship_chat_openchatentry' WHERE dtype='achimfritz_championship_openchatentry'");
		$this->addSql("UPDATE achimfritz_championship_chat_domain_model_chatentry SET dtype='achimfritz_championship_chat_tipgroupchatentry' WHERE dtype='achimfritz_championship_tipgroupchatentry'");
	}

	/**
	 * @param Schema $schema
	 * @return void
	 */
	public function down(Schema $schema) {
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");

		$this->addSql("UPDATE achimfritz_championship_chat_domain_model_chatentry SET dtype='achimfritz_championship_openchatentry' WHERE dtype='achimfritz_championship_chat_openchatentry'");
		$this->addSql("UPDATE achimfritz_championship_chat_domain_model_chatentry SET dtype='achimfritz_championship_tipgroupchatentry' WHERE dtype='achimfritz_championship_chat_tipgroupchatentry'");

		$this->addSql("ALTER TABLE achimfritz_championship_tip_domain_model_tipgr_c2a81_users_join CHANGE tip_tipgroupresultmatrix championship_tipgroupresultmatrix VARCHAR(40) NOT NULL");
		$this->addSql("ALTER TABLE achimfritz_championship_tip_domain_model_tipgr_c2a81_users_join CHANGE user_user championship_user VARCHAR(40) NOT NULL");
		$this->addSql("ALTER TABLE achimfritz_championship_tip_domain_model_tipgro_c2a81_rows_join CHANGE tip_tipgroupresultmatrix championship_tipgroupresultmatrix VARCHAR(40) NOT NULL");
		$this->addSql("ALTER TABLE achimfritz_championship_tip_domain_model_tipgro_c2a81_rows_join CHANGE tip_tipgroupresultmatrixrow championship_tipgroupresultmatrixrow VARCHAR(40) NOT NULL");
		$this->addSql("ALTER TABLE achimfritz_championship_tip_domain_model_tipgro_d24a5_tips_join CHANGE tip_tipgroupresultmatrixrow championship_tipgroupresultmatrixrow VARCHAR(40) NOT NULL");
		$this->addSql("ALTER TABLE achimfritz_championship_tip_domain_model_tipgro_d24a5_tips_join CHANGE tip_tip championship_tip VARCHAR(40) NOT NULL");
		$this->addSql("ALTER TABLE achimfritz_championship_user_domain_model_user_tipgroups_join CHANGE user_user championship_user VARCHAR(40) NOT NULL");
		$this->addSql("ALTER TABLE achimfritz_championship_user_domain_model_user_tipgroups_join CHANGE tip_tipgroup championship_tipgroup VARCHAR(40) NOT NULL");

		$this->addSql("RENAME TABLE achimfritz_championship_chat_domain_model_chatentry TO achimfritz_championship_domain_model_chatentry");
		$this->addSql("RENAME TABLE achimfritz_championship_user_domain_model_contactrequest TO achimfritz_championship_domain_model_contactrequest");
		$this->addSql("RENAME TABLE achimfritz_championship_chat_domain_model_openchatentry TO achimfritz_championship_domain_model_openchatentry");
		$this->addSql("RENAME TABLE achimfritz_championship_user_domain_model_password TO achimfritz_championship_domain_model_password");
		$this->addSql("RENAME TABLE achimfritz_championship_tip_domain_model_ranking TO achimfritz_championship_domain_model_ranking");
		$this->addSql("RENAME TABLE achimfritz_championship_user_domain_model_registrationrequest TO achimfritz_championship_domain_model_registrationrequest");
		$this->addSql("RENAME TABLE achimfritz_championship_tip_domain_model_tip TO achimfritz_championship_domain_model_tip");
		$this->addSql("RENAME TABLE achimfritz_championship_tip_domain_model_tipgroup TO achimfritz_championship_domain_model_tipgroup");
		$this->addSql("RENAME TABLE achimfritz_championship_chat_domain_model_tipgroupchatentry TO achimfritz_championship_domain_model_tipgroupchatentry");
		$this->addSql("RENAME TABLE achimfritz_championship_tip_domain_model_tipgr_c2a81_users_join TO achimfritz_championship_domain_model_tipgroupr_95a10_users_join");
		$this->addSql("RENAME TABLE achimfritz_championship_tip_domain_model_tipgro_c2a81_rows_join TO achimfritz_championship_domain_model_tipgroupre_95a10_rows_join");
		$this->addSql("RENAME TABLE achimfritz_championship_tip_domain_model_tipgro_d24a5_tips_join TO achimfritz_championship_domain_model_tipgroupre_edab4_tips_join");
		$this->addSql("RENAME TABLE achimfritz_championship_tip_domain_model_tipgroupresultmatrix TO achimfritz_championship_domain_model_tipgroupresultmatrix");
		$this->addSql("RENAME TABLE achimfritz_championship_tip_domain_model_tipgroupresultma_d24a5 TO achimfritz_championship_domain_model_tipgroupresultmatrixrow");
		$this->addSql("RENAME TABLE achimfritz_championship_user_domain_model_user TO achimfritz_championship_domain_model_user");
		$this->addSql("RENAME TABLE achimfritz_championship_user_domain_model_user_tipgroups_join TO achimfritz_championship_domain_model_user_tipgroups_join");

	}
}