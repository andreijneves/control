<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Employee $model */

$this->title = 'Criar Funcionário';
$this->params['breadcrumbs'][] = ['label' => 'Funcionários', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employee-create">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
