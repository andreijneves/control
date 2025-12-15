<?php

use app\models\User;
use yii\helpers\Url;

class LoginCest
{
    public function ensureThatLoginWorks(AcceptanceTester $I)
    {
        $this->ensureAdminUser();

        $I->amOnPage(Url::toRoute('/auth/auth/login'));
        $I->see('Entrar', 'h1');

        $I->amGoingTo('try to login with correct credentials');
        $I->fillField('input[name="LoginForm[username]"]', 'admin');
        $I->fillField('input[name="LoginForm[password]"]', 'admin');
        $I->click('login-button');
        $I->wait(2);

        $I->expectTo('see user info');
        $I->see('Sair');
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
