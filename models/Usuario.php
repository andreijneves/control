<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class Usuario extends ActiveRecord implements IdentityInterface
{
    const ROLE_ADMIN_GERAL = 'admin_geral';
    const ROLE_ADMIN_EMPRESA = 'admin_empresa';
    const ROLE_FUNCIONARIO = 'funcionario';
    const ROLE_CLIENTE = 'cliente';

    public static function tableName()
    {
        return '{{%usuario}}';
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => date('Y-m-d H:i:s'),
            ],
        ];
    }

    public function rules()
    {
        return [
            [['username', 'password_hash', 'auth_key'], 'required'],
            [['empresa_id'], 'integer'],
            [['username', 'email'], 'string', 'max' => 255],
            [['password_hash', 'access_token'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['role'], 'string', 'max' => 50],
            [['nome_completo'], 'string', 'max' => 255],
            [['telefone'], 'string', 'max' => 20],
            [['status'], 'integer'],
            [['username'], 'unique'],
            [['email'], 'email'],
            [['empresa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Empresa::class, 'targetAttribute' => ['empresa_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Usuário',
            'password_hash' => 'Senha',
            'auth_key' => 'Auth Key',
            'access_token' => 'Access Token',
            'role' => 'Função',
            'empresa_id' => 'Empresa',
            'nome_completo' => 'Nome Completo',
            'email' => 'E-mail',
            'telefone' => 'Telefone',
            'status' => 'Status',
            'created_at' => 'Criado em',
            'updated_at' => 'Atualizado em',
        ];
    }

    public function getEmpresa()
    {
        return $this->hasOne(Empresa::class, ['id' => 'empresa_id']);
    }

    public function getFuncionario()
    {
        return $this->hasOne(Funcionario::class, ['usuario_id' => 'id']);
    }

    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => 1]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token, 'status' => 1]);
    }

    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => 1]);
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public function generateAccessToken()
    {
        $this->access_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN_GERAL;
    }

    public function isAdminEmpresa()
    {
        return $this->role === self::ROLE_ADMIN_EMPRESA;
    }

    public function isFuncionario()
    {
        return $this->role === self::ROLE_FUNCIONARIO;
    }

    public function isCliente()
    {
        return $this->role === self::ROLE_CLIENTE;
    }
}
