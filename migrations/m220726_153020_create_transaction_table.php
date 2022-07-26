<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%transaction}}`.
 */
class m220726_153020_create_transaction_table extends Migration
{
	/**
	 * {@inheritdoc}
	 */
	public function safeUp()
	{
		$this->createTable('{{%transaction}}', [
			'id' => $this->primaryKey(),
			'dt' => $this->dateTime() . ' DEFAULT NOW()',
			'sum' => $this->decimal(10, 2)->notNull(),
			'account_id' => $this->integer()->notNull(),
		]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown()
	{
		$this->dropTable('{{%transaction}}');
	}
}
