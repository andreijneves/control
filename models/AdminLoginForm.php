<?php

namespace app\models;

use Yii;
use yii\base\Model;

class AdminLoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_admin = false;

    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
        ];
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $admin = $this->getAdmin();
            if (!$admin || !$admin->validatePassword($this->password)) {
                $this->addError($attribute, 'Usuário ou senha incorretos.');
            }
        }
    }

    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->adminUser->login($this->getAdmin(), $this->rememberMe ? 3600*24*30 : 0);
        }
        return false;
    }

    public function getAdmin()
    {
        if ($this->_admin === false) {
            $this->_admin = SystemAdmin::findByUsername($this->username);
        }
        return $this->_admin;
    }
}
