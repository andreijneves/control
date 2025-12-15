<?php

use app\models\User;

class LoginFormCest
{
    public function _before(\FunctionalTester $I)
    {
        $this->ensureAdminUser();
        $I->amOnRoute('auth/auth/login');
    }

    public function openLoginPage(\FunctionalTester $I)
    {
        $I->see('Entrar', 'h1');
    }

    // demonstrates `amLoggedInAs` method
    public function internalLoginById(\FunctionalTester $I)
    {
        $user = $this->ensureAdminUser();
        $I->amLoggedInAs($user->id);
        $I->amOnPage('/');
        $I->see('Sair (admin)');
    }

    // demonstrates `amLoggedInAs` method
    public function internalLoginByInstance(\FunctionalTester $I)
    {
        $I->amLoggedInAs($this->ensureAdminUser());
        $I->amOnPage('/');
        $I->see('Sair (admin)');
    }

    public function loginWithEmptyCredentials(\FunctionalTester $I)
    {
        $I->submitForm('#login-form', []);
        $I->expectTo('see validations errors');
        $I->see('Informe o usuario.');
        $I->see('Informe a senha.');
    }

    public function loginWithWrongCredentials(\FunctionalTester $I)
    {
        $I->submitForm('#login-form', [
            'LoginForm[username]' => 'admin',
            'LoginForm[password]' => 'wrong',
        ]);
        $I->expectTo('see validations errors');
        $I->see('Usuario ou senha incorretos.');
    }

    public function loginSuccessfully(\FunctionalTester $I)
    {
        $I->submitForm('#login-form', [
            'LoginForm[username]' => 'admin',
            'LoginForm[password]' => 'admin',
        ]);
        $I->see('Sair (admin)');
        $I->dontSeeElement('form#login-form');
    }

    private function ensureAdminUser(): User
    {
        $user = User::findOne(['username' => 'admin']);
        if ($user === null) {
            $user = new User();
            $user->id = 100;
            $user->username = 'admin';
            $user->setPassword('admin');
            $user->generateAuthKey();
            $user->generateAccessToken();
            $user->role = User::ROLE_ADM_GERAL;
            $user->status = 10;
            $user->save(false);
        }

        return $user;
    }
}
