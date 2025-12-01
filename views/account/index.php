<?php
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Usuários';
?>
<div class="account-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Novo Usuário', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'username',
            'email:email',
            'role',
            [
                'class' => 'yii\\grid\\ActionColumn',
            ],
        ],
    ]) ?>
</div>
