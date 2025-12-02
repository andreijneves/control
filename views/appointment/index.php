<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\Appointment;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var yii\widgets\ActiveForm $searchModel */

$this->title = 'Agendamentos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="appointment-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'client_name',
            'client_phone',
            [
                'attribute' => 'service_id',
                'value' => function($model) {
                    return $model->service ? $model->service->name : '';
                },
                'label' => 'Serviço',
            ],
            [
                'attribute' => 'employee_id',
                'value' => function($model) {
                    return $model->employee ? $model->employee->name : '';
                },
                'label' => 'Profissional',
            ],
            [
                'attribute' => 'appointment_date',
                'value' => function($model) {
                    return Yii::$app->formatter->asDate($model->appointment_date, 'dd/MM/yyyy');
                },
                'label' => 'Data',
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

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
