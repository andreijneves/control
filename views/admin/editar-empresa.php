<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Editar Empresa';
$this->params['breadcrumbs'][] = ['label' => 'Empresas', 'url' => ['empresas']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nome') ?>
    <?= $form->field($model, 'cnpj') ?>
    <?= $form->field($model, 'email') ?>
    <?= $form->field($model, 'telefone') ?>
    <?= $form->field($model, 'endereco')->textarea(['rows' => 3]) ?>
    <?= $form->field($model, 'status')->dropDownList(['1' => 'Ativo', '0' => 'Inativo']) ?>

    <div class="form-group">
        <?= Html::submitButton('Atualizar', ['class' => 'btn btn-success']) ?>
        <?= Html::a('Cancelar', ['empresas'], ['class' => 'btn btn-secondary ms-2']) ?>
    </div>

<?php ActiveForm::end(); ?>
