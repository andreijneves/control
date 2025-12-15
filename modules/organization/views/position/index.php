<?php

use yii\helpers\Html;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Cargos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="position-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Criar Cargo', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'organization_id',
                'value' => function($model) {
                    return $model->organization ? $model->organization->name : '-';
                },
                'label' => 'Organização',
            ],
            'name',
            'description:ntext',
            [
                'attribute' => 'status',
                'value' => function($model) {
                    return $model->status == 10 ? 'Ativo' : 'Inativo';
                },
            ],
            'created_at:datetime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
