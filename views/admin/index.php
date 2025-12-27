<?php

use yii\bootstrap5\Html;

$this->title = 'Painel de Administração';
?>

<h1>Painel de Administração</h1>

<div class="row mt-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h5 class="card-title">Empresas</h5>
                <h2><?= $totalEmpresas ?></h2>
                <p><?= Html::a('Gerenciar', ['empresas'], ['class' => 'btn btn-light btn-sm']) ?></p>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h5 class="card-title">Usuários</h5>
                <h2><?= $totalUsuarios ?></h2>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <h5 class="card-title">Funcionários</h5>
                <h2><?= $totalFuncionarios ?></h2>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h5 class="card-title">Serviços</h5>
                <h2><?= $totalServicos ?></h2>
            </div>
        </div>
    </div>
</div>
