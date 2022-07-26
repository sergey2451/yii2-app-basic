<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%transfer}}`.
 */
class m220726_154720_create_transfer_table extends Migration
{
	/**
	 * {@inheritdoc}
	 */
	public function safeUp()
	{
		$this->createTable('{{%transfer}}', [
			'id' => $this->primaryKey(),
			'from_account_id' => $this->integer()->notNull(),
			'to_account_id' => $this->integer()->notNull(),
			'sum' => $this->decimal(10, 2)->null() . ' DEFAULT NULL',
		]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown()
	{
		$this->dropTable('{{%transfer}}');
	}
}
