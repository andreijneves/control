<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Login Cliente';
$this->params['breadcrumbs'][] = ['label' => 'Empresas Disponíveis', 'url' => ['empresas']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="login-cliente">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="card">
                <div class="card-header bg-success text-white text-center">
                    <h1 class="card-title mb-0">
                        <i class="fas fa-sign-in-alt"></i> 
                        Login Cliente
                    </h1>
                </div>
                
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-user-circle"></i>
                        Acesse sua conta para gerenciar seus agendamentos.
                    </div>
                    
                    <?php $form = ActiveForm::begin([
                        'id' => 'login-form',
                        'layout' => 'horizontal',
                        'fieldConfig' => [
                            'template' => "{label}\n{input}\n{error}",
                            'labelOptions' => ['class' => 'col-lg-3 col-form-label'],
                            'inputOptions' => ['class' => 'form-control'],
                            'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
                        ],
                    ]); ?>

                    <?= $form->field($model, 'username')->textInput([
                        'placeholder' => 'Digite seu e-mail',
                        'autofocus' => true
                    ])->label('E-mail') ?>

                    <?= $form->field($model, 'password')->passwordInput([
                        'placeholder' => 'Digite sua senha'
                    ])->label('Senha') ?>

                    <?= $form->field($model, 'rememberMe')->checkbox([
                        'template' => "<div class=\"form-check\">{input} {label}</div>\n{error}",
                    ])->label('Lembrar de mim') ?>

                    <div class="form-group text-center">
                        <?= Html::submitButton('🔐 Entrar', ['class' => 'btn btn-success btn-lg px-5', 'name' => 'login-button']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                    
                    <hr>
                    
                    <div class="text-center">
                        <p class="mb-3">Ainda não tem uma conta?</p>
                        <?= Html::a(
                            '<i class="fas fa-user-plus"></i> Cadastrar-se como Cliente', 
                            ['/cliente/cadastro'], 
                            ['class' => 'btn btn-primary btn-lg']
                        ) ?>
                        
                        <div class="mt-3">
                            <small class="text-muted">
                                É funcionário ou administrador? 
                                <?= Html::a('Login empresarial', ['/site/login'], ['class' => 'fw-bold']) ?>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-4">
                <?= Html::a('← Voltar para Lista de Empresas', ['empresas'], ['class' => 'btn btn-secondary']) ?>
            </div>
        </div>
    </div>
</div>

<div class="row mt-5">
    <div class="col-12">
        <div class="card bg-light">
            <div class="card-body">
                <h5 class="card-title">
                    <i class="fas fa-question-circle text-info"></i> 
                    Como funciona?
                </h5>
                <div class="row">
                    <div class="col-md-6">
                        <h6>Para Clientes:</h6>
                        <ul>
                            <li>Cadastre-se gratuitamente</li>
                            <li>Navegue pelas empresas disponíveis</li>
                            <li>Agende serviços rapidamente</li>
                            <li>Acompanhe seus agendamentos</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6>Benefícios:</h6>
                        <ul>
                            <li>Acesso a múltiplas empresas</li>
                            <li>Histórico completo de agendamentos</li>
                            <li>Notificações automáticas</li>
                            <li>Interface simples e intuitiva</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>