<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Criar Serviço';
$this->params['breadcrumbs'][] = ['label' => 'Serviços', 'url' => ['servicos']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nome') ?>
    <?= $form->field($model, 'descricao')->textarea(['rows' => 3]) ?>
    <?= $form->field($model, 'preco')->textInput(['type' => 'number', 'step' => '0.01']) ?>
    <?= $form->field($model, 'duracao_minutos')->textInput(['type' => 'number']) ?>
    <?= $form->field($model, 'status')->dropDownList(['1' => 'Ativo', '0' => 'Inativo']) ?>

    <div class="form-group">
        <?= Html::submitButton('Salvar', ['class' => 'btn btn-success']) ?>
        <?= Html::a('Cancelar', ['servicos'], ['class' => 'btn btn-secondary ms-2']) ?>
    </div>

<?php ActiveForm::end(); ?>
