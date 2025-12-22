<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

// Se tem empresa_id, buscar a empresa
$empresa = null;
if (isset($empresa_id) && $empresa_id) {
    $empresa = \app\models\Empresa::findOne($empresa_id);
}

$this->title = $empresa ? 'Login - ' . $empresa->nome : 'Login Cliente';
?>

<div class="login-cliente-publico">
    <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">
            <div class="login-card">
                <div class="login-header">
                    <h1 class="login-title">
                        🔐 Acesse sua Conta
                    </h1>
                    <?php if ($empresa): ?>
                        <p class="login-subtitle">
                            Faça login para agendar serviços na <strong><?= Html::encode($empresa->nome) ?></strong>
                        </p>
                    <?php else: ?>
                        <p class="login-subtitle">
                            Acesse sua conta para gerenciar agendamentos
                        </p>
                    <?php endif; ?>
                </div>
                
                <div class="login-body">
                    <?php $form = ActiveForm::begin([
                        'id' => 'login-form-cliente'
                    ]); ?>

                    <div class="form-group mb-3">
                        <?= $form->field($model, 'username')->textInput([
                            'placeholder' => 'seu.email@exemplo.com',
                            'autofocus' => true,
                            'class' => 'form-control form-control-lg'
                        ])->label('E-mail', ['class' => 'form-label']) ?>
                    </div>

                    <div class="form-group mb-3">
                        <?= $form->field($model, 'password')->passwordInput([
                            'placeholder' => '••••••••',
                            'class' => 'form-control form-control-lg'
                        ])->label('Senha', ['class' => 'form-label']) ?>
                    </div>

                    <div class="form-group mb-4">
                        <?= $form->field($model, 'rememberMe')->checkbox([
                            'template' => "<div class=\"form-check\">{input} {label}</div>",
                            'class' => 'form-check-input'
                        ])->label('Lembrar de mim', ['class' => 'form-check-label']) ?>
                    </div>

                    <div class="form-group mb-3">
                        <?= Html::submitButton('Entrar', [
                            'class' => 'btn btn-login btn-lg w-100',
                            'name' => 'login-button'
                        ]) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
                
                <div class="login-footer">
                    <div class="text-center">
                        <p class="text-muted mb-2">Ainda não tem conta?</p>
                        <?php if ($empresa): ?>
                            <?= Html::a(
                                'Criar conta na ' . Html::encode($empresa->nome), 
                                ['/cliente/area-publica', 'empresa_id' => $empresa->id], 
                                ['class' => 'btn btn-outline-primary']
                            ) ?>
                            <div class="mt-3">
                                <?= Html::a('← Voltar para ' . Html::encode($empresa->nome), 
                                    ['/cliente/area-publica', 'empresa_id' => $empresa->id], 
                                    ['class' => 'btn btn-link btn-sm']) ?>
                            </div>
                        <?php else: ?>
                            <?= Html::a('Cadastrar-se', ['/cliente/cadastro'], ['class' => 'btn btn-outline-primary']) ?>
                            <div class="mt-3">
                                <?= Html::a('← Voltar para Empresas', ['empresas'], ['class' => 'btn btn-link btn-sm']) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.login-cliente-publico {
    min-height: 80vh;
    display: flex;
    align-items: center;
    padding: 2rem 0;
}

.login-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.1);
    overflow: hidden;
}

.login-header {
    background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%);
    color: white;
    padding: 2rem;
    text-align: center;
}

.login-title {
    font-size: 1.8rem;
    font-weight: 600;
    margin: 0;
}

.login-subtitle {
    margin: 0.5rem 0 0 0;
    opacity: 0.9;
    font-size: 1rem;
}

.login-body {
    padding: 2rem;
}

.form-label {
    font-weight: 600;
    color: #4a5568;
    margin-bottom: 0.5rem;
}

.form-control-lg {
    padding: 0.75rem 1rem;
    font-size: 1rem;
    border-radius: 8px;
    border: 2px solid #e2e8f0;
    transition: all 0.3s ease;
}

.form-control-lg:focus {
    border-color: #4299e1;
    box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.1);
}

.btn-login {
    background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%);
    border: none;
    color: white;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.btn-login:hover {
    background: linear-gradient(135deg, #3182ce 0%, #2c5aa0 100%);
    transform: translateY(-2px);
    color: white;
}

.login-footer {
    background: #f8fafc;
    padding: 1.5rem 2rem;
    border-top: 1px solid #e2e8f0;
}

.btn-outline-primary {
    border-color: #4299e1;
    color: #4299e1;
}

.btn-outline-primary:hover {
    background: #4299e1;
    border-color: #4299e1;
    color: white;
}

@media (max-width: 768px) {
    .login-header, .login-body, .login-footer {
        padding: 1.5rem;
    }
    
    .login-title {
        font-size: 1.5rem;
    }
}
</style>