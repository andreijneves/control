<?php

namespace app\models;

use Yii;

class ContactForm extends \yii\base\Model
{
    public $nome;
    public $email;
    public $assunto;
    public $mensagem;
    public $verifyCode;


    public function rules()
    {
        return [
            [['nome', 'email', 'assunto', 'mensagem'], 'required'],
            ['email', 'email'],
            ['verifyCode', 'captcha'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'nome' => 'Nome',
            'email' => 'E-mail',
            'assunto' => 'Assunto',
            'mensagem' => 'Mensagem',
            'verifyCode' => 'Código de Verificação',
        ];
    }

    public function contact($email)
    {
        if ($this->validate()) {
            Yii::$app->mailer->compose()
                ->setTo($email)
                ->setFrom([$this->email => $this->nome])
                ->setSubject($this->assunto)
                ->setTextBody($this->mensagem)
                ->send();

            return true;
        }
        return false;
    }
}
