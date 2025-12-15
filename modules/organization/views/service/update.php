<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Service $model */

$this->title = 'Atualizar Serviço: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Serviços', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Atualizar';
?>
<div class="service-update">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
