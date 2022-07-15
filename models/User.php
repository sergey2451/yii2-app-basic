<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;


/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $email
 * @property string $password_hash
 * @property string $confirm_password
 */
class User extends ActiveRecord implements IdentityInterface
{
	// public $password;
	// public $authKey;
	// public $accessToken;
	public $confirm_password;

	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return '{{%user}}';
	}

	/**
	 * {@inheritdoc}
	 */
	public static function findIdentity($id)
	{
		return static::findOne($id);
	}

	/**
	 * {@inheritdoc}
	 */
	public static function findIdentityByAccessToken($token, $type = null)
	{
		return static::findOne(['access_token' => $token]);
	}

	/**
	 * Finds user by username
	 *
	 * @param string $username
	 * @return static|null
	 */
	public static function findByUsername($username)
	{
		return static::findOne(['username' => $username]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getAuthKey()
	{
		return null;
	}

	/**
	 * {@inheritdoc}
	 */
	public function validateAuthKey($authKey)
	{
		return $this->authKey === $authKey;
	}

	/**
	 * Validates password
	 *
	 * @param string $password password to validate
	 * @return bool if password provided is valid for current user
	 */
	public function validatePassword($password)
	{
		return Yii::$app->getSecurity()->validatePassword($password, $this->password_hash);
	}

	/**
	 * Generates password hash from password and sets it to the model
	 *
	 * @param string $password_hash
	 */
	public function setPassword($password_hash)
	{
		$this->password_hash = Yii::$app->security->generatePasswordHash($password_hash);
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

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['username', 'email'], 'required'],
			[['username', 'email', 'password_hash', 'confirm_password'], 'string', 'max' => 255],
			['confirm_password', 'compare', 'compareAttribute' => 'password_hash'],
			[['username'], 'unique'],
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
			'password_hash' => 'Password',
			'confirm_password' => 'Confirm Password',
		];
	}
}
