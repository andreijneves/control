<?php
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Serviços';
?>
<div class="service-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Novo Serviço', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'name',
            'duration_min:integer',
            [
                'attribute' => 'price',
                'format' => ['decimal', 2],
            ],
            [
                'class' => 'yii\\grid\\ActionColumn',
            ],
        ],
    ]) ?>
</div>
