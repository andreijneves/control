<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Organization;

/** @var yii\web\View $this */
/** @var app\models\Position $model */
/** @var yii\bootstrap5\ActiveForm $form */

$user = Yii::$app->user->identity;
?>

<div class="position-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php if ($user->isAdmGeral()): ?>
        <?= $form->field($model, 'organization_id')->dropDownList(
            ArrayHelper::map(Organization::find()->all(), 'id', 'name'),
            ['prompt' => 'Selecione uma organização']
        ) ?>
    <?php else: ?>
        <div class="mb-3">
            <label class="form-label">Organização</label>
            <input type="text" class="form-control" readonly value="<?= Html::encode($model->organization ? $model->organization->name : $user->organization->name) ?>">
            <?= Html::activeHiddenInput($model, 'organization_id', ['value' => $user->organization_id]) ?>
        </div>
    <?php endif; ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 4]) ?>

    <?= $form->field($model, 'status')->dropDownList([
        10 => 'Ativo',
        0 => 'Inativo',
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Salvar', ['class' => 'btn btn-success']) ?>
        <?= Html::a('Cancelar', ['index'], ['class' => 'btn btn-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
