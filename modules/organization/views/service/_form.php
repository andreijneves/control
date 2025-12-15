<?php

use app\models\Organization;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Service $model */
/** @var yii\bootstrap5\ActiveForm $form */

$isAdmGeral = Yii::$app->user->identity->isAdmGeral();
?>

<div class="service-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php if ($isAdmGeral): ?>
        <?= $form->field($model, 'organization_id')->dropDownList(
            ArrayHelper::map(Organization::find()->all(), 'id', 'name'),
            ['prompt' => 'Selecione uma organização']
        ) ?>
    <?php else: ?>
        <?= $form->field($model, 'organization_id')->hiddenInput()->label(false) ?>
    <?php endif; ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 3]) ?>

    <?= $form->field($model, 'price')->textInput(['type' => 'number', 'step' => '0.01']) ?>

    <?= $form->field($model, 'duration')->textInput(['type' => 'number'])->hint('Duração em minutos') ?>

    <?= $form->field($model, 'status')->dropDownList([
        10 => 'Ativo',
        0 => 'Inativo',
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Salvar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
