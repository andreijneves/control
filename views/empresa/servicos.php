<?php

use yii\bootstrap5\Html;
use yii\grid\GridView;

$this->title = 'Serviços';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<p>
    <?= Html::a('Criar Serviço', ['criar-servico'], ['class' => 'btn btn-success']) ?>
</p>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'id',
        'nome',
        'descricao:text',
        'preco',
        'duracao_minutos',
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update} {delete}',
            'buttons' => [
                'update' => function($url, $model) {
                    return Html::a('Editar', ['editar-servico', 'id' => $model->id], ['class' => 'btn btn-sm btn-primary']);
                },
                'delete' => function($url, $model) {
                    return Html::a('Deletar', ['deletar-servico', 'id' => $model->id], [
                        'class' => 'btn btn-sm btn-danger',
                        'data-confirm' => 'Tem certeza?',
                        'data-method' => 'post',
                    ]);
                },
            ],
        ],
    ],
]); ?>
