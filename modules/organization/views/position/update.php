<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Position $model */

$this->title = 'Atualizar Cargo: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Cargos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Atualizar';
?>
<div class="position-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
