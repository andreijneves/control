<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Cadastro de Cliente';
$this->params['breadcrumbs'][] = ['label' => 'Empresas Disponíveis', 'url' => ['empresas']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="cadastro-cliente">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-primary text-white text-center">
                    <h1 class="card-title mb-0">
                        <i class="fas fa-user-plus"></i> 
                        Cadastro de Cliente
                    </h1>
                    <p class="mb-0">Empresa: <?= Html::encode($empresa->nome) ?></p>
                </div>
                
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        <strong>Cadastre-se na empresa <?= Html::encode($empresa->nome) ?></strong> e tenha acesso aos agendamentos online.
                    </div>
                    
                    <?php $form = ActiveForm::begin(['id' => 'form-cadastro-cliente']); ?>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <h5><i class="fas fa-user"></i> Dados Pessoais</h5>
                            
                            <?= $form->field($cliente, 'nome')->textInput([
                                'maxlength' => true,
                                'placeholder' => 'Seu nome completo',
                                'required' => true
                            ])->label('Nome Completo *') ?>
                            
                            <?= $form->field($cliente, 'email')->input('email', [
                                'maxlength' => true,
                                'placeholder' => 'seu@email.com',
                                'required' => true
                            ])->label('E-mail *') ?>
                            
                            <?= $form->field($cliente, 'telefone')->textInput([
                                'maxlength' => true,
                                'placeholder' => '(11) 99999-9999'
                            ])->label('Telefone') ?>
                            
                            <div class="form-group">
                                <label class="form-label">Senha *</label>
                                <input type="password" 
                                       class="form-control" 
                                       name="senha" 
                                       placeholder="Mínimo 6 caracteres"
                                       required 
                                       minlength="6">
                                <div class="form-text">Mínimo 6 caracteres</div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <h5><i class="fas fa-id-card"></i> Informações Adicionais</h5>
                            
                            <?= $form->field($cliente, 'cpf')->textInput([
                                'maxlength' => true,
                                'placeholder' => '000.000.000-00'
                            ])->label('CPF') ?>
                            
                            <?= $form->field($cliente, 'endereco')->textarea([
                                'rows' => 3,
                                'placeholder' => 'Rua, número, bairro, cidade...'
                            ])->label('Endereço Completo') ?>
                            
                            <div class="alert alert-success">
                                <h6><i class="fas fa-check-circle"></i> Benefícios</h6>
                                <ul class="mb-0 small">
                                    <li>Acesso a múltiplas empresas</li>
                                    <li>Histórico de agendamentos</li>
                                    <li>Notificações por e-mail</li>
                                    <li>Perfil personalizado</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="form-group text-center">
                        <?= Html::submitButton('📝 Criar Conta', ['class' => 'btn btn-primary btn-lg px-5']) ?>
                        <div class="mt-3">
                            <small class="text-muted">
                                Já tem conta? 
                                <?= Html::a('Faça login aqui', ['/cliente/login-cliente'], ['class' => 'fw-bold']) ?>
                            </small>
                        </div>
                    </div>
                    
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
            
            <div class="text-center mt-4">
                <?= Html::a('← Voltar para Lista de Empresas', ['empresas'], ['class' => 'btn btn-secondary']) ?>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Máscara para CPF
    const cpfInput = document.querySelector('input[name="Cliente[cpf]"]');
    if (cpfInput) {
        cpfInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
            e.target.value = value;
        });
    }
    
    // Máscara para telefone
    const telefoneInput = document.querySelector('input[name="Cliente[telefone]"]');
    if (telefoneInput) {
        telefoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length <= 10) {
                value = value.replace(/(\d{2})(\d)/, '($1) $2');
                value = value.replace(/(\d{4})(\d)/, '$1-$2');
            } else {
                value = value.replace(/(\d{2})(\d)/, '($1) $2');
                value = value.replace(/(\d{5})(\d)/, '$1-$2');
            }
            e.target.value = value;
        });
    }
});
</script>