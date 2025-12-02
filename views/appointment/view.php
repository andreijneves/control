<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Appointment;

/** @var yii\web\View $this */
/** @var app\models\Appointment $model */

$this->title = 'Agendamento #' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Agendamentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="appointment-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if ($model->status === Appointment::STATUS_PENDING): ?>
            <?= Html::a('Confirmar', ['confirm', 'id' => $model->id], [
                'class' => 'btn btn-success',
                'data' => [
                    'confirm' => 'Confirmar este agendamento?',
                    'method' => 'post',
                ],
            ]) ?>
            <?= Html::a('Cancelar', ['cancel', 'id' => $model->id], [
                'class' => 'btn btn-warning',
                'data' => [
                    'confirm' => 'Cancelar este agendamento?',
                    'method' => 'post',
                ],
            ]) ?>
        <?php endif; ?>
        
        <?php if ($model->status === Appointment::STATUS_CONFIRMED): ?>
            <?= Html::a('Concluir', ['complete', 'id' => $model->id], [
                'class' => 'btn btn-primary',
                'data' => [
                    'confirm' => 'Marcar como concluído?',
                    'method' => 'post',
                ],
            ]) ?>
            <?= Html::a('Cancelar', ['cancel', 'id' => $model->id], [
                'class' => 'btn btn-warning',
                'data' => [
                    'confirm' => 'Cancelar este agendamento?',
                    'method' => 'post',
                ],
            ]) ?>
        <?php endif; ?>
        
        <?= Html::a('Editar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Excluir', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Tem certeza que deseja excluir este agendamento?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'service_id',
                'value' => $model->service ? $model->service->name : '',
                'label' => 'Serviço',
            ],
            [
                'attribute' => 'employee_id',
                'value' => $model->employee ? $model->employee->name : '',
                'label' => 'Profissional',
            ],
            'client_name',
            'client_email:email',
            'client_phone',
            [
                'attribute' => 'appointment_date',
                'value' => Yii::$app->formatter->asDate($model->appointment_date, 'dd/MM/yyyy'),
            ],
            'appointment_time',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function($model) {
                    $colors = [
                        Appointment::STATUS_PENDING => 'warning',
                        Appointment::STATUS_CONFIRMED => 'info',
                        Appointment::STATUS_CANCELLED => 'danger',
                        Appointment::STATUS_COMPLETED => 'success',
                    ];
                    $color = $colors[$model->status] ?? 'secondary';
                    return Html::tag('span', $model->getStatusLabel(), ['class' => "badge bg-$color"]);
                },
            ],
            'notes:ntext',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
