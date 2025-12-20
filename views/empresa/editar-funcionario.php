<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Editar Funcionário';
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
        <?= Html::submitButton('Atualizar', ['class' => 'btn btn-success']) ?>
        <?= Html::a('Cancelar', ['funcionarios'], ['class' => 'btn btn-secondary ms-2']) ?>
    </div>

<?php ActiveForm::end(); ?>
