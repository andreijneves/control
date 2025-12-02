<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Service;
use app\models\Employee;
use app\models\Appointment;

/** @var yii\web\View $this */
/** @var app\models\Appointment $model */
/** @var yii\widgets\ActiveForm $form */

$this->title = 'Editar Agendamento: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Agendamentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="appointment-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="appointment-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'service_id')->dropDownList(
            ArrayHelper::map(
                Service::find()
                    ->where(['barbershop_id' => Yii::$app->user->identity->barbershop_id])
                    ->all(),
                'id',
                'name'
            ),
            ['prompt' => 'Selecione um serviço']
        ) ?>

        <?= $form->field($model, 'employee_id')->dropDownList(
            ArrayHelper::map(
                Employee::find()
                    ->where(['barbershop_id' => Yii::$app->user->identity->barbershop_id])
                    ->all(),
                'id',
                'name'
            ),
            ['prompt' => 'Selecione um profissional']
        ) ?>

        <?= $form->field($model, 'client_name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'client_email')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'client_phone')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'appointment_date')->input('date') ?>

        <?= $form->field($model, 'appointment_time')->input('time') ?>

        <?= $form->field($model, 'status')->dropDownList(Appointment::getStatuses()) ?>

        <?= $form->field($model, 'notes')->textarea(['rows' => 6]) ?>

        <div class="form-group">
            <?= Html::submitButton('Salvar', ['class' => 'btn btn-success']) ?>
            <?= Html::a('Cancelar', ['view', 'id' => $model->id], ['class' => 'btn btn-secondary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
