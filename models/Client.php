<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "client".
 *
 * @property int $id
 * @property string $name
 * @property string $surname
 *
 * @property Account[] $accounts
 */
class Client extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'client';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['name', 'surname', 'patronymic'], 'required'],
			[['name', 'surname', 'patronymic'], 'string', 'max' => 255],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'name' => 'Name',
			'surname' => 'Surname',
			'patronimic' => 'Patronymic',
		];
	}

	/**
	 * Gets query for [[Accounts]].
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getAccounts()
	{
		return $this->hasMany(Account::class, ['client_id' => 'id']);
	}
}
