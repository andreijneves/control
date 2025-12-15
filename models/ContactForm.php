<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm é o modelo por trás do formulário de contato.
 */
class ContactForm extends Model
{
    public $name;
    public $email;
    public $subject;
    public $body;
    public $verifyCode;


    /**
     * @return array as regras de validação.
     */
    public function rules()
    {
        return [
            [['name', 'email', 'subject', 'body'], 'required'],
            ['email', 'email'],
            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * @return array labels personalizados dos atributos
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Nome',
            'email' => 'E-mail',
            'subject' => 'Assunto',
            'body' => 'Mensagem',
            'verifyCode' => 'Código de Verificação',
        ];
    }

    /**
     * Envia um e-mail para o endereço especificado usando as informações coletadas por este modelo.
     * @param string $email o endereço de e-mail de destino
     * @return bool se o modelo passou na validação
     */
    public function contact($email)
    {
        if ($this->validate()) {
            Yii::$app->mailer->compose()
                ->setTo($email)
                ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
                ->setReplyTo([$this->email => $this->name])
                ->setSubject($this->subject)
                ->setTextBody($this->body)
                ->send();

            return true;
        }
        return false;
    }
}
