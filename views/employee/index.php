<?php
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Funcionários';
?>
<div class="employee-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Novo Funcionário', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'name',
            'email:email',
            'phone',
            [
                'class' => 'yii\\grid\\ActionColumn',
            ],
        ],
    ]) ?>
</div>
