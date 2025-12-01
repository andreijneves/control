<?php

namespace app\models;

use Yii;
use yii\base\Model;

class SignupForm extends Model
{
    public $barbershop_name;
    public $barbershop_email;
    public $username;
    public $email;
    public $password;

    public function rules()
    {
        return [
            [['barbershop_name', 'barbershop_email', 'username', 'email', 'password'], 'required'],
            [['barbershop_name'], 'string', 'max' => 120],
            [['barbershop_email', 'email'], 'email'],
            [['username'], 'string', 'min' => 3, 'max' => 64],
            [['password'], 'string', 'min' => 6],
        ];
    }

    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $barbershop = new Barbershop();
            $barbershop->name = $this->barbershop_name;
            $barbershop->email = $this->barbershop_email;
            if (!$barbershop->save()) {
                $this->addErrors($barbershop->getErrors());
                $transaction->rollBack();
                return null;
            }

            $account = new Account();
            $account->barbershop_id = $barbershop->id;
            $account->username = $this->username;
            $account->email = $this->email;
            $account->role = Account::ROLE_ADMIN;
            $account->generateAuthKey();
            $account->setPassword($this->password);
            if (!$account->save()) {
                $this->addErrors($account->getErrors());
                $transaction->rollBack();
                return null;
            }

            $transaction->commit();
            return $account;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            $this->addError('barbershop_name', $e->getMessage());
            return null;
        }
    }
}
