<?php

use yii\helpers\Html;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Organizações';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="organization-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Criar Organização', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'cnpj',
            'email:email',
            'phone',
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
