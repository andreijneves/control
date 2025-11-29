<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Usuários', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Deletar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Tem certeza que deseja deletar este usuário?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'email:email',
            [
                'label' => 'Nome',
                'value' => $model->profile ? $model->profile->name : '',
            ],
            [
                'label' => 'Perfil',
                'value' => function($model) {
                    if ($model->profile) {
                        $roles = \app\models\Profile::getRolesList();
                        return $roles[$model->profile->role] ?? $model->profile->role;
                    }
                    return '';
                }
            ],
            [
                'attribute' => 'status',
                'value' => $model->status == \app\models\User::STATUS_ACTIVE ? 'Ativo' : 'Inativo',
            ],
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
