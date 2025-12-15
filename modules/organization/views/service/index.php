<?php

use yii\helpers\Html;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Serviços';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="service-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Criar Serviço', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'organization_id',
                'value' => 'organization.name',
            ],
            'name',
            'price:currency',
            'duration',
            [
                'attribute' => 'status',
                'value' => function($model) {
                    return $model->status == 10 ? 'Ativo' : 'Inativo';
                },
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
