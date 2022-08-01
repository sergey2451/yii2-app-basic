<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "transfer".
 *
 * @property int $id
 * @property int $from_account_id
 * @property int $to_account_id
 * @property float|null $sum
 *
 * @property Account $fromAccount
 * @property Account $toAccount
 */
class Transfer extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'transfer';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['from_account_id', 'to_account_id', 'sum'], 'required'],
			[['from_account_id', 'to_account_id'], 'integer'],
			[['sum'], 'number'],
			[['from_account_id'], 'exist', 'skipOnError' => true, 'targetClass' => Account::class, 'targetAttribute' => ['from_account_id' => 'id']],
			[['to_account_id'], 'exist', 'skipOnError' => true, 'targetClass' => Account::class, 'targetAttribute' => ['to_account_id' => 'id']],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'from_account_id' => 'From Account ID',
			'to_account_id' => 'To Account ID',
			'sum' => 'Sum',
		];
	}

	/**
	 * Gets query for [[FromAccount]].
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getFromAccount()
	{
		return $this->hasOne(Account::class, ['id' => 'from_account_id']);
	}

	/**
	 * Gets query for [[ToAccount]].
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getToAccount()
	{
		return $this->hasOne(Account::class, ['id' => 'to_account_id']);
	}
}
