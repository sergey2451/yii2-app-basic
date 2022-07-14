<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $email
 * @property string $password_hash
 * @property string $confirm_password
 */
class User extends \yii\db\ActiveRecord
{
	public $confirm_password;
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'user';
	}

	public static function findIdentity($id)
	{
		return static::findOne($id);
	}

	public function beforeSave($insert)
	{
		if ($insert) {
			$this->setPassword($this->password_hash);
		} else {
			if (!empty($this->password_hash)) {
				$this->setPassword($this->password_hash);
			} else {
				$this->password_hash = (string) $this->getOldAttribute('password_hash');
			}
		}
		return parent::beforeSave($insert);
	}

	public function setPassword($password_hash)
	{
		$this->password_hash = Yii::$app->security->generatePasswordHash($password_hash);
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['username', 'email', 'password_hash', 'confirm_password'], 'required'],
			[['username', 'email', 'password_hash', 'confirm_password'], 'string', 'max' => 255],
			['confirm_password', 'compare', 'compareAttribute' => 'password_hash'],
			[['email'], 'unique'],
		];
	}

	/**
	 * {@inheritdoc}  
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'username' => 'Username',
			'email' => 'Email',
			'password_hash' => 'Password Hash',
			'confirm_password' => 'Confirm Password',
		];
	}
}
