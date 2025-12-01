<?php
use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'Dashboard';
?>
<div class="dashboard-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>Bem-vindo! Use o menu para gerenciar:</p>
    <ul>
        <li><?= Html::a('Funcionários', ['employee/index']) ?></li>
        <li><?= Html::a('Serviços', ['service/index']) ?></li>
        <li><?= Html::a('Usuários', ['account/index']) ?></li>
    </ul>
</div>
