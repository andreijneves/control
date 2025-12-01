<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Employee */

$this->title = 'Editar Funcionário';
?>
<div class="employee-update">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form', compact('model')) ?>
</div>
