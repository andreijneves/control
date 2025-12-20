<?php

use yii\bootstrap5\Html;
use yii\grid\GridView;

$this->title = 'Funcionários';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<p>
    <?= Html::a('Criar Funcionário', ['criar-funcionario'], ['class' => 'btn btn-success']) ?>
</p>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'id',
        'nome',
        'cpf',
        'email:email',
        'cargo',
        [
            'label' => 'Horários',
            'format' => 'raw',
            'value' => function($model) {
                return Html::a('Configurar', ['configurar-horarios', 'funcionario_id' => $model->id], ['class' => 'btn btn-sm btn-info']);
            }
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update}',
            'buttons' => [
                'update' => function($url, $model) {
                    return Html::a('Editar', ['editar-funcionario', 'id' => $model->id], ['class' => 'btn btn-sm btn-primary']);
                },
            ],
        ],
    ],
]); ?>
