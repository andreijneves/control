<?php

use yii\bootstrap5\Html;

$this->title = 'Control - gestao de Servicos';
?>

<div class="jumbotron text-center bg-light p-5 rounded-lg m-5">
    <h1 class="display-4">Bem-vindo ao Control</h1>
    <p class="lead">Sistema moderno de agendamento de serviços</p>
    <hr class="my-4">
    <p>Gerencie sua empresa, serviços, funcionários e agendamentos em um único lugar.</p>
    
    <div class="mt-4">
    <p class="text-muted mb-3">
        <strong>Transforme sua operação!</strong> Automatize agendamentos, reduza cancelamentos e 
        aumente a satisfação dos seus clientes. Ganhe mais tempo para focar no que realmente importa: 
        fazer seu negócio crescer.
    </p>
        <?= Html::a('Cadastrar Empresa', ['/site/cadastro-empresa'], ['class' => 'btn btn-primary btn-lg me-2']) ?>
      
    </div>
</div>

<div class="row my-5">
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-body text-center">
                <h5 class="card-title">Gerencie Serviços</h5>
                <p class="card-text">Cadastre e organize todos os serviços da sua empresa.</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-body text-center">
                <h5 class="card-title">Controle de Funcionários</h5>
                <p class="card-text">Gerencie funcionários e seus horários disponíveis.</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-body text-center">
                <h5 class="card-title">Agendamentos Fáceis</h5>
                <p class="card-text">Permita que clientes agendem serviços de forma simples.</p>
            </div>
        </div>
    </div>
</div>
