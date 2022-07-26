<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "transaction".
 *
 * @property int $id
 * @property string $dt
 * @property float|null $sum
 * @property int $account_id
 *
 * @property Account $account
 */
class Transaction extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'transaction';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['account_id', 'sum'], 'required'],
			[['dt'], 'safe'],
			[['sum'], 'number'],
			[['account_id'], 'integer'],
			[['account_id'], 'exist', 'skipOnError' => true, 'targetClass' => Account::class, 'targetAttribute' => ['account_id' => 'id']],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'dt' => 'Date & time',
			'sum' => 'Sum',
			'account_id' => 'Account ID',
		];
	}

	/**
	 * Gets query for [[Account]].
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getAccount()
	{
		return $this->hasOne(Account::class, ['id' => 'account_id']);
	}
}
