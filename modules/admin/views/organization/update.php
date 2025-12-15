<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Organization $model */

$this->title = 'Atualizar Organização: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Organizações', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Atualizar';
?>
<div class="organization-update">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
