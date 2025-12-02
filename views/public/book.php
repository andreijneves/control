<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var app\models\Appointment $model */
/** @var app\models\Barbershop $barbershop */
/** @var app\models\Service[] $services */
/** @var app\models\Employee[] $employees */

$this->title = 'Agendar Horário - ' . $barbershop->name;
?>
<div class="appointment-book">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1 class="mb-4"><?= Html::encode($this->title) ?></h1>

                <?php $form = ActiveForm::begin(['id' => 'book-form']); ?>

                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Informações do Agendamento</h5>
                        
                        <?= $form->field($model, 'service_id')->dropDownList(
                            ArrayHelper::map($services, 'id', function($service) {
                                return $service->name . ' - R$ ' . number_format($service->price, 2, ',', '.');
                            }),
                            ['prompt' => 'Selecione um serviço']
                        ) ?>

                        <?= $form->field($model, 'employee_id')->dropDownList(
                            ArrayHelper::map($employees, 'id', 'name'),
                            ['prompt' => 'Selecione um profissional']
                        ) ?>

                        <?= $form->field($model, 'appointment_date')->input('date', [
                            'min' => date('Y-m-d'),
                            'max' => date('Y-m-d', strtotime('+60 days'))
                        ]) ?>

                        <?= $form->field($model, 'appointment_time')->input('time') ?>

                        <?= $form->field($model, 'notes')->textarea(['rows' => 3]) ?>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Seus Dados</h5>
                        
                        <?= $form->field($model, 'client_name')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'client_email')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'client_phone')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>

                <div class="form-group">
                    <?= Html::submitButton('Agendar', ['class' => 'btn btn-success btn-lg']) ?>
                    <?= Html::a('Voltar', ['barbershop', 'id' => $barbershop->id], ['class' => 'btn btn-secondary btn-lg']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
