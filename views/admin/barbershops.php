<?php
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Gerenciar Barbearias';
?>
<div class="admin-barbershops">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Nova Barbearia', ['create-barbershop'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'name',
            'email:email',
            'phone',
            'address',
            [
                'attribute' => 'created_at',
                'format' => 'datetime',
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<i class="bi bi-eye"></i>', ['view-barbershop', 'id' => $model->id], ['class' => 'btn btn-sm btn-info', 'title' => 'Ver']);
                    },
                    'update' => function ($url, $model) {
                        return Html::a('<i class="bi bi-pencil"></i>', ['update-barbershop', 'id' => $model->id], ['class' => 'btn btn-sm btn-warning', 'title' => 'Editar']);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<i class="bi bi-trash"></i>', ['delete-barbershop', 'id' => $model->id], [
                            'class' => 'btn btn-sm btn-danger',
                            'title' => 'Excluir',
                            'data-confirm' => 'Tem certeza que deseja excluir esta barbearia?',
                            'data-method' => 'post',
                        ]);
                    },
                ],
            ],
        ],
    ]) ?>
</div>
