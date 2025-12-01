<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class Account extends ActiveRecord implements IdentityInterface
{
        public $password; // virtual attribute for forms
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 10;

    const ROLE_ADMIN = 'admin';
    const ROLE_STAFF = 'staff';

    public static function tableName()
    {
        return '{{%account}}';
    }

    public function behaviors()
    {
        return [TimestampBehavior::class];
    }

    public function rules()
    {
        return [
            [['barbershop_id', 'username', 'email', 'password_hash', 'auth_key'], 'required'],
            [['barbershop_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['username'], 'string', 'max' => 64],
            [['email'], 'string', 'max' => 180],
            [['email'], 'email'],
            [['role'], 'string', 'max' => 32],
            [['auth_key'], 'string', 'max' => 32],
            [['password_hash', 'password_reset_token'], 'string'],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
            [['role'], 'default', 'value' => self::ROLE_ADMIN],
            [['status'], 'default', 'value' => self::STATUS_ACTIVE],
            [['barbershop_id'], 'exist', 'targetClass' => Barbershop::class, 'targetAttribute' => ['barbershop_id' => 'id']],
            [['password'], 'string', 'min' => 6],
            [['password'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'barbershop_id' => 'Barbearia',
        ];
    }

    public function getBarbershop()
    {
        return $this->hasOne(Barbershop::class, ['id' => 'barbershop_id']);
    }

    // IdentityInterface
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null; // not used
    }

    public static function findByUsername($username)
    {
        return static::find()->where(['username' => $username, 'status' => self::STATUS_ACTIVE])->one();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    // Password helpers
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
}
