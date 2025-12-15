<?php

/** @var yii\web\View $this */
/** @var app\models\Organization $organization */

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;

$this->title = 'Painel da Organização';
$this->params['breadcrumbs'][] = $this->title;

$servicesProvider = new ActiveDataProvider([
    'query' => $organization->getServices(),
    'pagination' => ['pageSize' => 5],
    'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
]);

$employeesProvider = new ActiveDataProvider([
    'query' => $organization->getEmployees(),
    'pagination' => ['pageSize' => 5],
    'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
]);
?>
<div class="org-dashboard">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="mb-3">
        <?= Html::a('Gerenciar Serviços', ['/organization/service/index'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Gerenciar Funcionários', ['/organization/employee/index'], ['class' => 'btn btn-secondary']) ?>
    </div>

    <div class="row">
        <div class="col-md-6 mb-4">
            <h3>Informações da Organização</h3>
            <?= DetailView::widget([
                'model' => $organization,
                'attributes' => [
                    'name',
                    'cnpj',
                    'email:email',
                    'phone',
                    'address:ntext',
                    [
                        'attribute' => 'status',
                        'value' => $organization->status == 10 ? 'Ativo' : 'Inativo',
                    ],
                ],
            ]) ?>
        </div>
        <div class="col-md-6 mb-4">
            <h3>Últimos Serviços</h3>
            <?= GridView::widget([
                'dataProvider' => $servicesProvider,
                'summary' => false,
                'columns' => [
                    'name',
                    'price:currency',
                    'duration',
                    [
                        'attribute' => 'status',
                        'value' => function($model){ return $model->status == 10 ? 'Ativo' : 'Inativo'; },
                    ],
                    ['class' => 'yii\grid\ActionColumn', 'controller' => '/organization/service'],
                ],
            ]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <h3>Últimos Funcionários</h3>
            <?= GridView::widget([
                'dataProvider' => $employeesProvider,
                'summary' => false,
                'columns' => [
                    'name',
                    'email:email',
                    'cpf',
                    'position',
                    [
                        'attribute' => 'status',
                        'value' => function($model){ return $model->status == 10 ? 'Ativo' : 'Inativo'; },
                    ],
                    ['class' => 'yii\grid\ActionColumn', 'controller' => '/organization/employee'],
                ],
            ]) ?>
        </div>
    </div>
</div>
