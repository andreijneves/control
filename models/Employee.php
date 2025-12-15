<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class Employee extends ActiveRecord
{
    public $password;
    public $password_confirm;

    public static function tableName()
    {
        return '{{%employee}}';
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
            [['organization_id', 'name', 'email'], 'required'],
            [['organization_id', 'user_id', 'status'], 'integer'],
            [['name', 'position'], 'string', 'max' => 255],
            [['cpf'], 'string', 'max' => 14],
            [['email'], 'email'],
            [['email'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 20],
            [['status'], 'default', 'value' => 10],
            [['cpf'], 'unique'],
            [['user_id'], 'unique'],
            [['organization_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organization::class, 'targetAttribute' => ['organization_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            
            // Senha requerida apenas na criação
            [['password', 'password_confirm'], 'required', 'on' => 'create'],
            [['password'], 'string', 'min' => 6],
            [['password_confirm'], 'compare', 'compareAttribute' => 'password', 'message' => 'As senhas não conferem.'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'organization_id' => 'Organização',
            'user_id' => 'Usuário',
            'name' => 'Nome',
            'cpf' => 'CPF',
            'email' => 'E-mail',
            'phone' => 'Telefone',
            'position' => 'Cargo',
            'status' => 'Status',
            'created_at' => 'Criado em',
            'updated_at' => 'Atualizado em',
            'password' => 'Senha',
            'password_confirm' => 'Confirmar Senha',
        ];
    }

    public function getOrganization()
    {
        return $this->hasOne(Organization::class, ['id' => 'organization_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        // Se é novo funcionário e tem senha definida, criar usuário
        if ($insert && !empty($this->password)) {
            $this->createUserAccount();
        }
    }

    protected function createUserAccount()
    {
        $user = new User();
        $user->username = $this->generateUsername();
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateAccessToken();
        $user->role = User::ROLE_FUNCIONARIO;
        $user->organization_id = $this->organization_id;
        $user->status = 10;

        if ($user->save()) {
            $this->user_id = $user->id;
            $this->save(false);
            return true;
        }

        return false;
    }

    protected function generateUsername()
    {
        $base = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', explode(' ', $this->name)[0]));
        $username = $base;
        $counter = 1;

        while (User::findOne(['username' => $username])) {
            $username = $base . $counter;
            $counter++;
        }

        return $username;
    }
}
