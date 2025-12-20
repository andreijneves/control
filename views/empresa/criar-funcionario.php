<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Criar Funcionário';
$this->params['breadcrumbs'][] = ['label' => 'Funcionários', 'url' => ['funcionarios']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nome') ?>
    <?= $form->field($model, 'cpf') ?>
    <?= $form->field($model, 'email') ?>
    <?= $form->field($model, 'telefone') ?>
    <?= $form->field($model, 'cargo') ?>

    <div class="form-group">
        <label class="form-label">Senha de Acesso</label>
        <?= Html::passwordInput('senha', '', ['class' => 'form-control']) ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Salvar', ['class' => 'btn btn-success']) ?>
        <?= Html::a('Cancelar', ['funcionarios'], ['class' => 'btn btn-secondary ms-2']) ?>
    </div>

<?php ActiveForm::end(); ?>
