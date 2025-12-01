<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Service */

$this->title = 'Novo Serviço';
?>
<div class="service-create">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form', compact('model')) ?>
</div>
