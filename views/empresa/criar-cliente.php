<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Criar Cliente';
$this->params['breadcrumbs'][] = ['label' => 'Clientes', 'url' => ['clientes']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nome') ?>
    <?= $form->field($model, 'cpf') ?>
    <?= $form->field($model, 'email') ?>
    <?= $form->field($model, 'telefone') ?>
    <?= $form->field($model, 'endereco')->textarea(['rows' => 3]) ?>

    <div class="form-group">
        <?= Html::submitButton('Salvar', ['class' => 'btn btn-success']) ?>
        <?= Html::a('Cancelar', ['clientes'], ['class' => 'btn btn-secondary ms-2']) ?>
    </div>

<?php ActiveForm::end(); ?>
