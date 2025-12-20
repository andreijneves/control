<?php

use yii\bootstrap5\Html;

$this->title = 'Sobre';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row mt-5">
    <div class="col-md-8 offset-md-2">
        <h1>Sobre o Control</h1>
        
        <p>Control é um sistema moderno de agendamento de serviços desenvolvido para facilitar o gerenciamento de empresas, funcionários e clientes.</p>
        
        <h3>Funcionalidades</h3>
        <ul>
            <li>Cadastro e gerenciamento de empresas</li>
            <li>Cadastro de serviços oferecidos</li>
            <li>Gerenciamento de funcionários e horários</li>
            <li>Cadastro de clientes</li>
            <li>Sistema de agendamento de serviços</li>
            <li>Dashboard com estatísticas</li>
        </ul>

        <h3>Como Começar</h3>
        <p><?= Html::a('Cadastre sua empresa agora!', ['/site/cadastro-empresa'], ['class' => 'btn btn-primary']) ?></p>
    </div>
</div>
