<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m220713_231344_create_user_table extends Migration
{
	/**
	 * {@inheritdoc}
	 */
	public function safeUp()
	{
		$this->createTable('{{%user}}', [
			'username' => $this->string()->notNull(),
			'email' => $this->string()->notNull()->unique(),
			'password_hash' => $this->string()->notNull(),
		]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown()
	{
		$this->dropTable('{{%user}}');
	}
}
