<?php

namespace tests\unit\models;

use app\models\LoginForm;
use app\models\User;
use Yii;

class LoginFormTest extends \Codeception\Test\Unit
{
    private $model;

    protected function _before()
    {
        $this->ensureUser('demo', 'demo', 101);
    }

    protected function _after()
    {
        \Yii::$app->user->logout();
    }

    public function testLoginNoUser()
    {
        $this->model = new LoginForm([
            'username' => 'not_existing_username',
            'password' => 'not_existing_password',
        ]);

        verify($this->model->login())->false();
        verify(\Yii::$app->user->isGuest)->true();
    }

    public function testLoginWrongPassword()
    {
        $this->model = new LoginForm([
            'username' => 'demo',
            'password' => 'wrong_password',
        ]);

        verify($this->model->login())->false();
        verify(\Yii::$app->user->isGuest)->true();
        verify($this->model->errors)->arrayHasKey('password');
    }

    public function testLoginCorrect()
    {
        $this->model = new LoginForm([
            'username' => 'demo',
            'password' => 'demo',
        ]);

        verify($this->model->login())->true();
        verify(\Yii::$app->user->isGuest)->false();
        verify($this->model->errors)->arrayHasNotKey('password');
    }

    private function ensureUser(string $username, string $password, int $id): User
    {
        $user = User::findOne(['username' => $username]);
        if ($user === null) {
            $user = new User();
            $user->id = $id;
            $user->username = $username;
            $user->setPassword($password);
            $user->generateAuthKey();
            $user->generateAccessToken();
            $user->role = User::ROLE_USUARIO;
            $user->status = 10;
            $user->save(false);
        }

        return $user;
    }
}
