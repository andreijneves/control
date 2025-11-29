<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Usuários';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Cadastrar Usuário', ['signup'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'username',
            'email:email',
            [
                'label' => 'Nome',
                'attribute' => 'profile.name',
            ],
            [
                'label' => 'Perfil',
                'attribute' => 'profile.role',
                'value' => function($model) {
                    $roles = \app\models\Profile::getRolesList();
                    return $model->profile ? ($roles[$model->profile->role] ?? $model->profile->role) : '';
                }
            ],
            [
                'attribute' => 'status',
                'value' => function($model) {
                    return $model->status == \app\models\User::STATUS_ACTIVE ? 'Ativo' : 'Inativo';
                }
            ],
            'created_at:datetime',

            ['class' => 'yii\grid\ActionColumn', 'template' => '{view} {delete}'],
        ],
    ]); ?>

</div>
