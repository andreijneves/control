<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Employee $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Funcionários', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employee-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Atualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Excluir', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Tem certeza que deseja excluir este funcionário?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'organization_id',
                'value' => $model->organization->name,
            ],
            [
                'attribute' => 'user_id',
                'value' => $model->user ? $model->user->username : 'Sem usuário',
            ],
            'name',
            'cpf',
            'email:email',
            'phone',
            'position',
            [
                'attribute' => 'status',
                'value' => $model->status == 10 ? 'Ativo' : 'Inativo',
            ],
            'created_at',
            'updated_at',
        ],
    ]) ?>
</div>
