<?php

use yii\bootstrap5\Html;
use yii\grid\GridView;

$this->title = 'Empresas';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<p>
    <?= Html::a('Criar Empresa', ['criar-empresa'], ['class' => 'btn btn-success']) ?>
</p>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        'id',
        'nome',
        'cnpj',
        'email:email',
        'telefone',
        [
            'attribute' => 'status',
            'value' => function($model) {
                return $model->status == 1 ? 'Ativo' : 'Inativo';
            }
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update} {delete}',
            'buttons' => [
                'update' => function($url, $model) {
                    return Html::a('Editar', ['editar-empresa', 'id' => $model->id], ['class' => 'btn btn-sm btn-primary']);
                },
                'delete' => function($url, $model) {
                    return Html::a('Deletar', ['deletar-empresa', 'id' => $model->id], [
                        'class' => 'btn btn-sm btn-danger',
                        'data-confirm' => 'Tem certeza que quer deletar?',
                        'data-method' => 'post',
                    ]);
                },
            ],
        ],
    ],
]); ?>
