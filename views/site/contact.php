<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\ContactForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\captcha\Captcha;

$this->title = 'Contato';

$this->registerCss("
.contact-section h1 {
    color: #2d3748;
    font-weight: 700;
    margin-bottom: 1.5rem;
    text-align: center;
}

.contact-section p {
    color: #4a5568;
    font-size: 1.1rem;
    text-align: center;
    margin-bottom: 2rem;
}

.contact-form {
    max-width: 600px;
    margin: 0 auto;
}

.form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    padding: 0.8rem 2rem;
    font-weight: 600;
    border-radius: 25px;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
}
");
?>
<div class="site-contact contact-section">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>

        <div class="alert alert-success">
            Obrigado por entrar em contato. Responderemos o mais breve possível.
        </div>

        <p>
            Note que se você ativar o depurador do Yii, poderá visualizar
            a mensagem de e-mail no painel de e-mail do depurador.
            <?php if (Yii::$app->mailer->useFileTransport): ?>
                Como a aplicação está em modo de desenvolvimento, o e-mail não é enviado, mas salvo como
                arquivo em <code><?= Yii::getAlias(Yii::$app->mailer->fileTransportPath) ?></code>.
                Configure a propriedade <code>useFileTransport</code> do componente <code>mail</code>
                da aplicação como false para habilitar o envio de e-mails.
            <?php endif; ?>
        </p>

    <?php else: ?>

        <p>
            Tem dúvidas ou quer saber mais sobre nosso sistema? Preencha o formulário abaixo e entraremos em contato o mais breve possível.
        </p>

        <div class="contact-form">

                <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

                    <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

                    <?= $form->field($model, 'email') ?>

                    <?= $form->field($model, 'subject') ?>

                    <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

                    <?= $form->field($model, 'verifyCode')->widget(Captcha::class, [
                        'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                    ]) ?>

                    <div class="form-group">
                        <?= Html::submitButton('Enviar', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                    </div>

                <?php ActiveForm::end(); ?>

        </div>

    <?php endif; ?>
</div>
