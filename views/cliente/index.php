<?php

use yii\bootstrap5\Html;

$this->title = 'Painel do Cliente - ' . $empresa->nome;
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="cliente-index">
    <!-- Header do painel -->
    <div class="jumbotron bg-info text-white text-center p-4 rounded mb-4">
        <h1 class="display-5">
            <i class="fas fa-user-circle"></i>
            Olá, <?= Html::encode($cliente->nome) ?>!
        </h1>
        <p class="lead">Bem-vindo ao painel da empresa <?= Html::encode($empresa->nome) ?></p>
    </div>

    <!-- Menu de navegação -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-compass"></i>
                        Navegação
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-4 mb-3">
                            <?= Html::a(
                                '<i class="fas fa-building fa-3x text-info mb-2"></i><br><strong>Sobre a Empresa</strong><br><small>Informações completas</small>',
                                ['/cliente/index'],
                                ['class' => 'btn btn-light border h-100 w-100 active']
                            ) ?>
                        </div>
                        <div class="col-md-4 mb-3">
                            <?= Html::a(
                                '<i class="fas fa-history fa-3x text-success mb-2"></i><br><strong>Histórico</strong><br><small>Meus agendamentos</small>',
                                ['/cliente/agendamentos'],
                                ['class' => 'btn btn-light border h-100 w-100']
                            ) ?>
                        </div>
                        <div class="col-md-4 mb-3">
                            <?= Html::a(
                                '<i class="fas fa-calendar-plus fa-3x text-primary mb-2"></i><br><strong>Novo Agendamento</strong><br><small>Agendar serviço</small>',
                                ['/cliente/novo-agendamento'],
                                ['class' => 'btn btn-light border h-100 w-100']
                            ) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Coluna principal - Informações da empresa -->
        <div class="col-lg-8">
            <!-- Sobre a empresa -->
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-building"></i>
                        Sobre a Empresa
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <h6><i class="fas fa-tag text-primary"></i> Nome</h6>
                            <p class="text-muted"><?= Html::encode($empresa->nome) ?></p>
                        </div>
                        <?php if ($empresa->email): ?>
                            <div class="col-md-6 mb-3">
                                <h6><i class="fas fa-envelope text-primary"></i> E-mail</h6>
                                <p class="text-muted"><?= Html::encode($empresa->email) ?></p>
                            </div>
                        <?php endif; ?>
                        <?php if ($empresa->telefone): ?>
                            <div class="col-md-6 mb-3">
                                <h6><i class="fas fa-phone text-primary"></i> Telefone</h6>
                                <p class="text-muted"><?= Html::encode($empresa->telefone) ?></p>
                            </div>
                        <?php endif; ?>
                        <?php if ($empresa->cidade): ?>
                            <div class="col-md-6 mb-3">
                                <h6><i class="fas fa-map-marker-alt text-primary"></i> Cidade</h6>
                                <p class="text-muted"><?= Html::encode($empresa->cidade) ?></p>
                            </div>
                        <?php endif; ?>
                        <?php if ($empresa->endereco): ?>
                            <div class="col-12 mb-3">
                                <h6><i class="fas fa-map text-primary"></i> Endereço</h6>
                                <p class="text-muted"><?= Html::encode($empresa->endereco) ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Horários de funcionamento -->
            <?php if (!empty($horarios)): ?>
                <div class="card mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-clock"></i>
                            Horários de Funcionamento
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-borderless">
                                <?php
                                $horariosPorDia = [];
                                foreach ($horarios as $horario) {
                                    $horariosPorDia[$horario->dia_semana] = $horario;
                                }
                                
                                $diasSemana = [
                                    1 => 'Segunda-feira',
                                    2 => 'Terça-feira',
                                    3 => 'Quarta-feira',
                                    4 => 'Quinta-feira',
                                    5 => 'Sexta-feira',
                                    6 => 'Sábado',
                                    0 => 'Domingo'
                                ];
                                
                                foreach ($diasSemana as $dia => $nomeDia):
                                    $horario = $horariosPorDia[$dia] ?? null;
                                ?>
                                    <tr>
                                        <td class="fw-bold text-primary" style="width: 150px;">
                                            <i class="fas fa-calendar-day"></i>
                                            <?= $nomeDia ?>
                                        </td>
                                        <td>
                                            <?php if ($horario && $horario->disponivel): ?>
                                                <span class="badge bg-success">
                                                    <i class="fas fa-clock"></i>
                                                    <?= substr($horario->hora_inicio, 0, 5) ?> - <?= substr($horario->hora_fim, 0, 5) ?>
                                                </span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">
                                                    <i class="fas fa-times"></i>
                                                    Fechado
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Sidebar - Serviços e profissionais -->
        <div class="col-lg-4">
            <!-- Serviços disponíveis -->
            <?php if (!empty($servicos)): ?>
                <div class="card mb-4">
                    <div class="card-header bg-secondary text-white">
                        <h6 class="mb-0">
                            <i class="fas fa-concierge-bell"></i>
                            Serviços Disponíveis
                        </h6>
                    </div>
                    <div class="card-body">
                        <?php foreach ($servicos as $servico): ?>
                            <div class="border-bottom pb-3 mb-3">
                                <h6 class="text-primary mb-1"><?= Html::encode($servico->nome) ?></h6>
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <strong class="text-success">
                                        <i class="fas fa-money-bill-wave"></i> R$ <?= number_format($servico->preco, 2, ',', '.') ?>
                                    </strong>
                                    <?php if ($servico->duracao_minutos): ?>
                                        <small class="text-muted">
                                            <i class="fas fa-clock"></i> <?= $servico->duracao_minutos ?> min
                                        </small>
                                    <?php endif; ?>
                                </div>
                                <?php if ($servico->descricao): ?>
                                    <small class="text-muted"><?= Html::encode($servico->descricao) ?></small>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Profissionais -->
            <?php if (!empty($funcionarios)): ?>
                <div class="card">
                    <div class="card-header bg-warning text-dark">
                        <h6 class="mb-0">
                            <i class="fas fa-users"></i>
                            Nossa Equipe
                        </h6>
                    </div>
                    <div class="card-body">
                        <?php foreach ($funcionarios as $funcionario): ?>
                            <div class="border-bottom pb-2 mb-2">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-user-circle fa-2x text-primary me-2"></i>
                                    <div>
                                        <strong><?= Html::encode($funcionario->nome) ?></strong><br>
                                        <small class="text-muted"><?= Html::encode($funcionario->cargo ?? 'Profissional') ?></small>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
