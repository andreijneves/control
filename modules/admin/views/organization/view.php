<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Organization $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Organizações', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="organization-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Atualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Excluir', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Tem certeza que deseja excluir esta organização?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'cnpj',
            'email:email',
            'phone',
            'address:ntext',
            [
                'attribute' => 'status',
                'value' => $model->status == 10 ? 'Ativo' : 'Inativo',
            ],
            'created_at',
            'updated_at',
        ],
    ]) ?>
</div>
