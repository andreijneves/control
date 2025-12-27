<?php

use yii\bootstrap5\Html;

$this->title = 'Painel da Empresa';
?>

<h1>Painel da Empresa</h1>

<div class="row mt-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h5 class="card-title">Serviços</h5>
                <h2><?= $totalServicos ?></h2>
                <p><?= Html::a('Gerenciar', ['servicos'], ['class' => 'btn btn-light btn-sm']) ?></p>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h5 class="card-title">Funcionários</h5>
                <h2><?= $totalFuncionarios ?></h2>
                <p><?= Html::a('Gerenciar', ['funcionarios'], ['class' => 'btn btn-light btn-sm']) ?></p>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <h5 class="card-title">Clientes</h5>
                <h2><?= $totalClientes ?></h2>
                <p><?= Html::a('Gerenciar', ['clientes'], ['class' => 'btn btn-light btn-sm']) ?></p>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h5 class="card-title">Agendamentos</h5>
                <h2><?= $totalAgendamentos ?></h2>
                <p><?= Html::a('Ver', ['agendamentos'], ['class' => 'btn btn-light btn-sm']) ?></p>
            </div>
        </div>
    </div>
</div>

<!-- Calendário Semanal -->
<div class="row mt-5">
    <div class="col-12">
        <?= $this->render('_calendario_semanal', [
            'agendamentosSemana' => $agendamentosSemana,
            'inicioSemana' => $inicioSemana,
            'fimSemana' => $fimSemana,
        ]) ?>
    </div>
</div>
