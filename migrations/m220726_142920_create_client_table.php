<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%client}}`.
 */
class m220726_142920_create_client_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%client}}', [
            'id' => $this->primaryKey(),
						'name' => $this->string()->notNull(),
						'surname' => $this->string()->notNull(),
						'patronymic' => $this->string()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%client}}');
    }
}
