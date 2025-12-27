<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use app\models\Empresa;
use yii\helpers\ArrayHelper;

$this->title = 'Editar Usuário: ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Usuários', 'url' => ['usuarios']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="editar-usuario">
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
                                <label class="form-label">Nova Senha</label>
                                <input type="password" name="password" class="form-control" minlength="6" placeholder="Deixe em branco para manter a atual">
                                <small class="text-muted">Deixe em branco se não quiser alterar a senha</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <?php if ($model->role !== 'admin'): ?>
                                <?= $form->field($model, 'role')->dropDownList([
                                    'admin' => '🔑 Admin Geral',
                                    'admin_empresa' => '🏢 Admin Empresa', 
                                    'funcionario' => '👤 Funcionário',
                                    'cliente' => '🛍️ Cliente',
                                ], ['id' => 'usuario-role']) ?>
                            <?php else: ?>
                                <?= $form->field($model, 'role')->textInput(['value' => '🔑 Admin Geral', 'readonly' => true]) ?>
                                <small class="text-muted">Tipo de Admin Geral não pode ser alterado</small>
                            <?php endif; ?>
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
                            <?php if ($model->role !== 'admin'): ?>
                                <?= $form->field($model, 'status')->dropDownList([
                                    1 => '✅ Ativo',
                                    0 => '❌ Inativo',
                                ]) ?>
                            <?php else: ?>
                                <?= $form->field($model, 'status')->textInput(['value' => '✅ Ativo', 'readonly' => true]) ?>
                                <small class="text-muted">Admin Geral sempre ativo</small>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="alert alert-info">
                        <strong>📊 Informações do Usuário:</strong><br>
                        <strong>ID:</strong> <?= $model->id ?><br>
                        <strong>Criado em:</strong> <?= Yii::$app->formatter->asDatetime($model->created_at, 'php:d/m/Y H:i') ?><br>
                        <strong>Última atualização:</strong> <?= Yii::$app->formatter->asDatetime($model->updated_at, 'php:d/m/Y H:i') ?><br>
                        <?php if ($model->empresa): ?>
                            <strong>Empresa:</strong> <?= Html::encode($model->empresa->nome) ?><br>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <div class="d-flex gap-2">
                            <?= Html::submitButton('💾 Salvar Alterações', ['class' => 'btn btn-success']) ?>
                            <?= Html::a('Cancelar', ['usuarios'], ['class' => 'btn btn-secondary']) ?>
                            <?php if ($model->role !== 'admin'): ?>
                                <?php if ($model->status == 1): ?>
                                    <?= Html::a('❌ Desativar Usuário', ['alterar-status-usuario', 'id' => $model->id, 'status' => 0], [
                                        'class' => 'btn btn-warning',
                                        'data-confirm' => 'Tem certeza que deseja desativar este usuário?'
                                    ]) ?>
                                <?php else: ?>
                                    <?= Html::a('✅ Ativar Usuário', ['alterar-status-usuario', 'id' => $model->id, 'status' => 1], [
                                        'class' => 'btn btn-success'
                                    ]) ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card bg-light">
                <div class="card-body">
                    <h6 class="card-title">📝 Informações</h6>
                    
                    <div class="alert alert-warning">
                        <strong>⚠️ Importante:</strong>
                        <ul class="mb-0 mt-2">
                            <li>Admin Geral não pode ser desativado</li>
                            <li>Admin Geral não pode ter tipo alterado</li>
                            <li>Senha em branco = manter atual</li>
                            <li>Admin Empresa precisa de empresa</li>
                        </ul>
                    </div>

                    <?php if ($model->role === 'admin'): ?>
                        <div class="alert alert-danger">
                            <strong>🔒 Usuário Protegido</strong><br>
                            Este é um administrador geral do sistema. Algumas opções estão bloqueadas por segurança.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const roleSelect = document.getElementById('usuario-role');
    const empresaSelect = document.getElementById('empresa-select');
    const empresaGroup = empresaSelect?.closest('.col-md-6');
    
    function toggleEmpresaField() {
        if (!roleSelect || !empresaSelect) return;
        
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
    
    if (roleSelect) {
        roleSelect.addEventListener('change', toggleEmpresaField);
        toggleEmpresaField(); // Executar na carga inicial
    }
});
</script>