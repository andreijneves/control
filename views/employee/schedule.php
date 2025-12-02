<?php
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $employee app\models\Employee */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Horários de ' . $employee->name;
?>
<div class="employee-schedule">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Adicionar Horário', ['add-schedule', 'id' => $employee->id], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Voltar', ['index'], ['class' => 'btn btn-secondary']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'attribute' => 'day_of_week',
                'value' => function($model) {
                    return $model->getDayName();
                }
            ],
            'start_time',
            'end_time',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
                'buttons' => [
                    'delete' => function ($url, $model) use ($employee) {
                        return Html::a('<i class="bi bi-trash"></i>', ['delete-schedule', 'id' => $employee->id, 'scheduleId' => $model->id], [
                            'class' => 'btn btn-sm btn-danger',
                            'data-confirm' => 'Tem certeza que deseja excluir este horário?',
                            'data-method' => 'post',
                        ]);
                    },
                ],
            ],
        ],
    ]) ?>
</div>
