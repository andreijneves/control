<?php

use yii\bootstrap5\Html;
use yii\grid\GridView;
use app\models\Agendamento;

$this->title = 'Agendamentos';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'id',
        [
            'attribute' => 'cliente_id',
            'value' => 'cliente.nome',
        ],
        [
            'attribute' => 'funcionario_id',
            'value' => 'funcionario.nome',
        ],
        [
            'attribute' => 'servico_id',
            'value' => 'servico.nome',
        ],
        'data_agendamento',
        [
            'attribute' => 'status',
            'value' => function($model) {
                return $model->getStatusLabel();
            }
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{confirm} {cancel}',
            'buttons' => [
                'confirm' => function($url, $model) {
                    if ($model->status == Agendamento::STATUS_PENDENTE) {
                        return Html::a('Confirmar', ['confirmar-agendamento', 'id' => $model->id], [
                            'class' => 'btn btn-sm btn-success',
                            'data-method' => 'post',
                        ]);
                    }
                    return '';
                },
                'cancel' => function($url, $model) {
                    if ($model->status != Agendamento::STATUS_CANCELADO) {
                        return Html::a('Cancelar', ['cancelar-agendamento', 'id' => $model->id], [
                            'class' => 'btn btn-sm btn-danger',
                            'data-confirm' => 'Tem certeza?',
                            'data-method' => 'post',
                        ]);
                    }
                    return '';
                },
            ],
        ],
    ],
]); ?>
