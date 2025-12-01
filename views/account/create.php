<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Account */

$this->title = 'Novo Usuário';
?>
<div class="account-create">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form', compact('model')) ?>
</div>
