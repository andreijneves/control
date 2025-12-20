<?php

use yii\bootstrap5\Html;
use yii\grid\GridView;

$this->title = 'Clientes';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<p>
    <?= Html::a('Criar Cliente', ['criar-cliente'], ['class' => 'btn btn-success']) ?>
</p>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'id',
        'nome',
        'cpf',
        'email:email',
        'telefone',
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update}',
            'buttons' => [
                'update' => function($url, $model) {
                    return Html::a('Editar', ['editar-cliente', 'id' => $model->id], ['class' => 'btn btn-sm btn-primary']);
                },
            ],
        ],
    ],
]); ?>
