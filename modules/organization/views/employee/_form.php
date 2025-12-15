<?php

use app\models\Organization;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Employee $model */
/** @var yii\bootstrap5\ActiveForm $form */

$isAdmGeral = Yii::$app->user->identity->isAdmGeral();
$isNewRecord = $model->isNewRecord;
?>

<div class="employee-form">

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

    <?= $form->field($model, 'cpf')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'position')->textInput(['maxlength' => true]) ?>

    <?php if ($isNewRecord): ?>
        <div class="alert alert-info">
            Um usuário será criado automaticamente para este funcionário com as credenciais abaixo.
        </div>

        <?= $form->field($model, 'password')->passwordInput() ?>

        <?= $form->field($model, 'password_confirm')->passwordInput() ?>
    <?php endif; ?>

    <?= $form->field($model, 'status')->dropDownList([
        10 => 'Ativo',
        0 => 'Inativo',
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Salvar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
