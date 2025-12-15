<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class Organization extends ActiveRecord
{
    private array $adminCredentials = [];
    public static function tableName()
    {
        return '{{%organization}}';
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
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['cnpj'], 'string', 'max' => 18],
            [['email'], 'email'],
            [['email'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 20],
            [['address'], 'string'],
            [['status'], 'integer'],
            [['status'], 'default', 'value' => 10],
            [['cnpj'], 'unique'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Nome',
            'cnpj' => 'CNPJ',
            'email' => 'E-mail',
            'phone' => 'Telefone',
            'address' => 'Endereço',
            'status' => 'Status',
            'created_at' => 'Criado em',
            'updated_at' => 'Atualizado em',
        ];
    }

    public function getServices()
    {
        return $this->hasMany(Service::class, ['organization_id' => 'id']);
    }

    public function getEmployees()
    {
        return $this->hasMany(Employee::class, ['organization_id' => 'id']);
    }

    public function getUsers()
    {
        return $this->hasMany(User::class, ['organization_id' => 'id']);
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if ($insert) {
            $this->createAdminUser();
        }
    }

    public function getAdminCredentials(): array
    {
        return $this->adminCredentials;
    }

    protected function createAdminUser(): void
    {
        $base = strtolower(preg_replace('/[^a-z0-9]/', '', $this->name));
        $username = $base ? $base.'adm' : 'org'.$this->id.'adm';
        $counter = 1;
        while (User::findOne(['username' => $username])) {
            $username = ($base ? $base.'adm' : 'org'.$this->id.'adm') . $counter;
            $counter++;
        }

        $password = Yii::$app->security->generateRandomString(8);

        $user = new User();
        $user->username = $username;
        $user->setPassword($password);
        $user->generateAuthKey();
        $user->generateAccessToken();
        $user->role = User::ROLE_ADM_ORG;
        $user->organization_id = $this->id;
        $user->status = 10;
        if ($user->save()) {
            $this->adminCredentials = [
                'username' => $username,
                'password' => $password,
            ];
        }
    }
}
