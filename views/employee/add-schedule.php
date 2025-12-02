<?php
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/* @var $this yii\web\View */
/* @var $employee app\models\Employee */
/* @var $model app\models\EmployeeSchedule */

$this->title = 'Adicionar Horário para ' . $employee->name;
?>
<div class="employee-add-schedule">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'day_of_week')->dropDownList(\app\models\EmployeeSchedule::getDaysOfWeek(), ['prompt' => 'Selecione...']) ?>
    <?= $form->field($model, 'start_time')->input('time') ?>
    <?= $form->field($model, 'end_time')->input('time') ?>

    <div class="form-group mt-3">
        <?= Html::submitButton('Salvar', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Cancelar', ['schedule', 'id' => $employee->id], ['class' => 'btn btn-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
