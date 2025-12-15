<?php

namespace app\models;

use app\models\Employee;
use app\models\Organization;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
    public const ROLE_ADM_GERAL = 'adm_geral';
    public const ROLE_ADM_ORG = 'adm_org';
    public const ROLE_FUNCIONARIO = 'funcionario';
    public const ROLE_USUARIO = 'usuario';

    public static function tableName()
    {
        return '{{%user}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'value' => fn() => date('Y-m-d H:i:s'),
            ],
        ];
    }

    public function rules()
    {
        return [
            [['username', 'password_hash', 'auth_key'], 'required'],
            [['username'], 'string', 'max' => 64],
            [['password_hash'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['access_token'], 'string', 'max' => 128],
            [['role'], 'string', 'max' => 32],
            [['status', 'organization_id'], 'integer'],
            [['username'], 'unique'],
            [['access_token'], 'unique'],
            [['role'], 'default', 'value' => self::ROLE_USUARIO],
            [['status'], 'default', 'value' => 10],
            [['organization_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organization::class, 'targetAttribute' => ['organization_id' => 'id']],
        ];
    }

    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => 10]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token, 'status' => 10]);
    }

    public static function findByUsername(string $username): ?self
    {
        return static::findOne(['username' => $username, 'status' => 10]);
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

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function setPassword(string $password): void
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    public function generateAuthKey(): void
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public function generateAccessToken(): void
    {
        $this->access_token = Yii::$app->security->generateRandomString(64);
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Usuário',
            'password_hash' => 'Hash da Senha',
            'auth_key' => 'Chave de Autenticação',
            'access_token' => 'Token de Acesso',
            'role' => 'Perfil',
            'organization_id' => 'Organização',
            'status' => 'Status',
            'created_at' => 'Criado em',
            'updated_at' => 'Atualizado em',
        ];
    }

    public function isAdmGeral(): bool
    {
        return $this->role === self::ROLE_ADM_GERAL;
    }

    public function isAdmOrg(): bool
    {
        return $this->role === self::ROLE_ADM_ORG;
    }

    public function isFuncionario(): bool
    {
        return $this->role === self::ROLE_FUNCIONARIO;
    }

    public function getOrganization()
    {
        return $this->hasOne(Organization::class, ['id' => 'organization_id']);
    }

    public function getEmployee()
    {
        return $this->hasOne(Employee::class, ['user_id' => 'id']);
    }
}
