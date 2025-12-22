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
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8 col-sm-10">
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
                                    ['/cliente/cadastro', 'empresa_id' => $empresa->id], 
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
</div>

<style>
.login-cliente-publico {
    margin: -3rem -3rem;
    padding: 2rem;
    background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
    min-height: 70vh;
    display: flex;
    align-items: center;
}

.login-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 20px 50px rgba(0,0,0,0.1);
    overflow: hidden;
    width: 100%;
    max-width: 500px;
    margin: 0 auto;
}

.login-header {
    background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%);
    color: white;
    padding: 2.5rem 2rem;
    text-align: center;
}

.login-title {
    font-size: 2rem;
    font-weight: 700;
    margin: 0 0 1rem 0;
    letter-spacing: -0.5px;
}

.login-subtitle {
    margin: 0;
    opacity: 0.95;
    font-size: 1.1rem;
    line-height: 1.5;
}

.login-body {
    padding: 2.5rem 2rem;
}

.form-label {
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 0.5rem;
    display: block;
}

.form-control-lg {
    padding: 1rem 1.25rem;
    font-size: 1.1rem;
    border-radius: 12px;
    border: 2px solid #e2e8f0;
    transition: all 0.3s ease;
    background: #f8fafc;
}

.form-control-lg:focus {
    border-color: #4299e1;
    box-shadow: 0 0 0 4px rgba(66, 153, 225, 0.1);
    background: white;
}

.btn-login {
    background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%);
    border: none;
    color: white;
    padding: 1rem 2rem;
    font-weight: 600;
    font-size: 1.1rem;
    border-radius: 12px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(66, 153, 225, 0.3);
}

.btn-login:hover {
    background: linear-gradient(135deg, #3182ce 0%, #2c5aa0 100%);
    transform: translateY(-2px);
    color: white;
    box-shadow: 0 6px 20px rgba(66, 153, 225, 0.4);
}

.form-check {
    padding: 0.5rem 0;
}

.form-check-input:checked {
    background-color: #4299e1;
    border-color: #4299e1;
}

.login-footer {
    background: #f8fafc;
    padding: 2rem;
    border-top: 1px solid #e2e8f0;
}

.btn-outline-primary {
    border: 2px solid #4299e1;
    color: #4299e1;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    border-radius: 12px;
    transition: all 0.3s ease;
}

.btn-outline-primary:hover {
    background: #4299e1;
    border-color: #4299e1;
    color: white;
    transform: translateY(-1px);
}

.btn-link {
    color: #718096;
    font-size: 0.9rem;
    text-decoration: none;
}

.btn-link:hover {
    color: #4299e1;
    text-decoration: underline;
}

/* Responsivo */
@media (max-width: 768px) {
    .login-cliente-publico {
        margin: -3rem -1.5rem;
        padding: 1rem;
        min-height: 60vh;
    }
    
    .login-header {
        padding: 2rem 1.5rem;
    }
    
    .login-title {
        font-size: 1.75rem;
    }
    
    .login-subtitle {
        font-size: 1rem;
    }
    
    .login-body, .login-footer {
        padding: 2rem 1.5rem;
    }
    
    .form-control-lg {
        padding: 0.875rem 1rem;
        font-size: 1rem;
    }
    
    .btn-login {
        padding: 0.875rem 1.5rem;
        font-size: 1rem;
    }
}

@media (max-width: 480px) {
    .login-cliente-publico {
        margin: -3rem -1rem;
        padding: 0.5rem;
    }
    
    .login-card {
        border-radius: 15px;
    }
    
    .login-header {
        padding: 1.5rem 1rem;
    }
    
    .login-title {
        font-size: 1.5rem;
    }
    
    .login-body, .login-footer {
        padding: 1.5rem 1rem;
    }
}
</style>