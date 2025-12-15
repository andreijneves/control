<?php

/** @var yii\web\View $this */
/** @var app\models\Organization $model */
/** @var yii\bootstrap5\ActiveForm $form */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Cadastro de Organização';

$this->registerCss("
.register-form {
    max-width: 600px;
    margin: 2rem auto;
    padding: 2rem;
}

.register-form h1 {
    color: #2d3748;
    font-weight: 700;
    margin-bottom: 0.5rem;
    text-align: center;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.register-form .subtitle {
    text-align: center;
    color: #718096;
    margin-bottom: 2rem;
    font-size: 1rem;
}

.register-form .form-group {
    margin-bottom: 1.5rem;
}

.register-form label {
    font-weight: 600;
    color: #4a5568;
    margin-bottom: 0.5rem;
    display: block;
}

.register-form .form-control {
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    padding: 0.75rem;
    transition: all 0.3s ease;
}

.register-form .form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.register-form .btn-register {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 0.875rem 2rem;
    border-radius: 25px;
    font-weight: 600;
    border: none;
    width: 100%;
    font-size: 1.1rem;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    transition: all 0.3s ease;
}

.register-form .btn-register:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
}

.register-form .help-block {
    color: #e53e3e;
    font-size: 0.875rem;
    margin-top: 0.25rem;
}

.register-info {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    padding: 1.5rem;
    border-radius: 12px;
    margin-bottom: 2rem;
    border-left: 4px solid #667eea;
}

.register-info h4 {
    color: #667eea;
    font-weight: 600;
    margin-bottom: 0.75rem;
    font-size: 1rem;
}

.register-info p {
    color: #4a5568;
    margin: 0;
    font-size: 0.95rem;
    line-height: 1.6;
}

.login-link {
    text-align: center;
    margin-top: 1.5rem;
    color: #718096;
}

.login-link a {
    color: #667eea;
    font-weight: 600;
    text-decoration: none;
}

.login-link a:hover {
    text-decoration: underline;
}
");
?>

<div class="register-form">
    <h1><?= Html::encode($this->title) ?></h1>
    <p class="subtitle">Preencha os dados para criar sua organização</p>

    <div class="register-info">
        <h4>ℹ️ Informações Importantes</h4>
        <p>
            Ao cadastrar sua organização, um usuário administrador será criado automaticamente. 
            As credenciais de acesso serão exibidas na tela seguinte. 
            <strong>Guarde-as em local seguro!</strong>
        </p>
    </div>

    <?php $form = ActiveForm::begin([
        'id' => 'register-form',
        'options' => ['class' => 'form-horizontal'],
    ]); ?>

        <?= $form->field($model, 'name')->textInput([
            'autofocus' => true,
            'placeholder' => 'Nome da Organização',
            'maxlength' => true
        ])->label('Nome da Organização') ?>

        <?= $form->field($model, 'cnpj')->textInput([
            'placeholder' => '00.000.000/0000-00',
            'maxlength' => true
        ])->label('CNPJ') ?>

        <?= $form->field($model, 'address')->textarea([
            'rows' => 3,
            'placeholder' => 'Endereço completo'
        ])->label('Endereço') ?>

        <?= $form->field($model, 'phone')->textInput([
            'placeholder' => '(00) 0000-0000',
            'maxlength' => true
        ])->label('Telefone') ?>

        <?= $form->field($model, 'email')->textInput([
            'type' => 'email',
            'placeholder' => 'email@exemplo.com',
            'maxlength' => true
        ])->label('E-mail') ?>

        <div class="form-group">
            <?= Html::submitButton('Cadastrar Organização', [
                'class' => 'btn btn-register',
                'name' => 'register-button'
            ]) ?>
        </div>

    <?php ActiveForm::end(); ?>

    <div class="login-link">
        Já possui cadastro? <?= Html::a('Faça login aqui', ['/auth/auth/login']) ?>
    </div>
</div>
