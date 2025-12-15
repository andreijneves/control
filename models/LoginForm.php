<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm é o modelo por trás do formulário de login.
 *
 * @property-read User|null $user
 *
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user = false;


    /**
     * @return array as regras de validação.
     */
    public function rules()
    {
        return [
            [['username'], 'required', 'message' => 'Informe o usuario.'],
            [['password'], 'required', 'message' => 'Informe a senha.'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Usuário',
            'password' => 'Senha',
            'rememberMe' => 'Lembrar de mim',
        ];
    }

    /**
     * Valida a senha.
     * Este método serve como validação inline para senha.
     *
     * @param string $attribute o atributo sendo validado
     * @param array $params os pares nome-valor adicionais da regra
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Usuario ou senha incorretos.');
            }
        }
    }

    /**
     * Faz o login de um usuário usando o nome de usuário e senha fornecidos.
     * @return bool se o usuário foi autenticado com sucesso
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }
        return false;
    }

    /**
     * Encontra usuário por [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}
