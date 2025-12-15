<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Employee $model */

$this->title = 'Atualizar Funcionário: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Funcionários', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Atualizar';
?>
<div class="employee-update">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
