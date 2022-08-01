<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%account}}`.
 */
class m220726_145539_create_account_table extends Migration
{
	/**
	 * {@inheritdoc}
	 */
	public function safeUp()
	{
		$this->createTable('{{%account}}', [
			'id' => $this->primaryKey(),
			'balance' => $this->decimal(10, 2)->null() . ' DEFAULT 0.00',
			'currency' => 'ENUM("BYN", "USD", "EUR")',
			'open_date' => $this->date()->notNull(),
			'client_id' => $this->integer()->notNull(),
		]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown()
	{
		$this->dropTable('{{%account}}');
	}
}
