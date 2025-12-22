<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use app\models\Empresa;
use yii\helpers\ArrayHelper;

$this->title = 'Criar Usuário';
$this->params['breadcrumbs'][] = ['label' => 'Usuários', 'url' => ['usuarios']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="criar-usuario">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><?= Html::encode($this->title) ?></h1>
        <?= Html::a('← Voltar', ['usuarios'], ['class' => 'btn btn-secondary']) ?>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <?php $form = ActiveForm::begin(); ?>

                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'email')->input('email', ['maxlength' => true]) ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'nome_completo')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'telefone')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Senha *</label>
                                <input type="password" name="password" class="form-control" required minlength="6" placeholder="Mínimo 6 caracteres">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'role')->dropDownList([
                                'admin' => '🔑 Admin Geral',
                                'admin_empresa' => '🏢 Admin Empresa',
                                'funcionario' => '👤 Funcionário',
                                'cliente' => '🛍️ Cliente',
                            ], ['prompt' => 'Selecione o tipo de usuário']) ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'empresa_id')->dropDownList(
                                ArrayHelper::map(Empresa::find()->where(['status' => 1])->all(), 'id', 'nome'),
                                [
                                    'prompt' => 'Selecione uma empresa (opcional)',
                                    'id' => 'empresa-select'
                                ]
                            ) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'status')->dropDownList([
                                1 => '✅ Ativo',
                                0 => '❌ Inativo',
                            ]) ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="d-flex gap-2">
                            <?= Html::submitButton('💾 Criar Usuário', ['class' => 'btn btn-success']) ?>
                            <?= Html::a('Cancelar', ['usuarios'], ['class' => 'btn btn-secondary']) ?>
                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card bg-light">
                <div class="card-body">
                    <h6 class="card-title">📝 Instruções</h6>
                    
                    <div class="alert alert-info">
                        <strong>👆 Tipos de Usuário:</strong>
                        <ul class="mb-0 mt-2">
                            <li><strong>Admin Geral:</strong> Acesso total</li>
                            <li><strong>Admin Empresa:</strong> Gerencia uma empresa</li>
                            <li><strong>Funcionário:</strong> Trabalha em uma empresa</li>
                            <li><strong>Cliente:</strong> Cliente de uma empresa</li>
                        </ul>
                    </div>

                    <div class="alert alert-warning">
                        <strong>⚠️ Empresa:</strong><br>
                        Obrigatória para Admin Empresa e Funcionário.<br>
                        Opcional para Cliente.<br>
                        Não necessária para Admin Geral.
                    </div>

                    <div class="alert alert-success">
                        <strong>🔒 Senha:</strong><br>
                        Mínimo 6 caracteres.<br>
                        Será criptografada automaticamente.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const roleSelect = document.getElementById('usuario-role');
    const empresaSelect = document.getElementById('empresa-select');
    const empresaGroup = empresaSelect.closest('.col-md-6');
    
    function toggleEmpresaField() {
        const role = roleSelect.value;
        if (role === 'admin_empresa' || role === 'funcionario') {
            empresaGroup.style.display = 'block';
            empresaSelect.required = true;
        } else if (role === 'admin') {
            empresaGroup.style.display = 'none';
            empresaSelect.required = false;
            empresaSelect.value = '';
        } else {
            empresaGroup.style.display = 'block';
            empresaSelect.required = false;
        }
    }
    
    roleSelect.addEventListener('change', toggleEmpresaField);
    toggleEmpresaField(); // Executar na carga inicial
});
</script>