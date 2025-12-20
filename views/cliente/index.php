<?php

use yii\bootstrap5\Html;

$this->title = 'Meu Painel - Cliente';
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

    <div class="row">
        <!-- Coluna principal - Agendamentos -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-calendar-alt"></i>
                        Meus Agendamentos
                    </h3>
                </div>
                <div class="card-body">
                    <?php if (!empty($agendamentos)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Data/Hora</th>
                                        <th>Empresa</th>
                                        <th>Serviço</th>
                                        <th>Funcionário</th>
                                        <th>Status</th>
                                        <th>Valor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($agendamentos as $agendamento): ?>
                                        <tr>
                                            <td>
                                                <strong><?= Yii::$app->formatter->asDate($agendamento->data_agendamento, 'dd/MM/yyyy') ?></strong><br>
                                                <small class="text-muted"><?= Yii::$app->formatter->asTime($agendamento->data_agendamento, 'HH:mm') ?></small>
                                            </td>
                                            <td>
                                                <i class="fas fa-building text-primary"></i>
                                                <?= Html::encode($agendamento->empresa->nome ?? 'N/A') ?>
                                            </td>
                                            <td>
                                                <i class="fas fa-concierge-bell"></i>
                                                <?= Html::encode($agendamento->servico->nome ?? 'N/A') ?>
                                            </td>
                                            <td>
                                                <i class="fas fa-user"></i>
                                                <?= Html::encode($agendamento->funcionario->nome ?? 'N/A') ?>
                                            </td>
                                            <td>
                                                <?php
                                                $statusClass = 'secondary';
                                                $statusIcon = 'clock';
                                                switch ($agendamento->status) {
                                                    case 'confirmado':
                                                        $statusClass = 'success';
                                                        $statusIcon = 'check-circle';
                                                        break;
                                                    case 'cancelado':
                                                        $statusClass = 'danger';
                                                        $statusIcon = 'times-circle';
                                                        break;
                                                    case 'concluido':
                                                        $statusClass = 'info';
                                                        $statusIcon = 'check-double';
                                                        break;
                                                }
                                                ?>
                                                <span class="badge bg-<?= $statusClass ?>">
                                                    <i class="fas fa-<?= $statusIcon ?>"></i>
                                                    <?= ucfirst($agendamento->status) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <strong class="text-success">
                                                    R$ <?= number_format($agendamento->servico->preco ?? 0, 2, ',', '.') ?>
                                                </strong>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                            <h4>Nenhum agendamento encontrado</h4>
                            <p class="text-muted">Você ainda não fez nenhum agendamento.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Sidebar - Ações e informações -->
        <div class="col-lg-4">
            <!-- Ações rápidas -->
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-lightning-bolt"></i>
                        Ações Rápidas
                    </h5>
                </div>
                <div class="card-body">
                    <?= Html::a(
                        '<i class="fas fa-calendar-plus"></i> Novo Agendamento',
                        ['/cliente/area-publica', 'empresa_id' => $empresa->id],
                        ['class' => 'btn btn-success btn-block w-100 mb-2']
                    ) ?>
                    
                    <?= Html::a(
                        '<i class="fas fa-building"></i> Área Pública da Empresa',
                        ['/cliente/area-publica', 'empresa_id' => $empresa->id],
                        ['class' => 'btn btn-primary btn-block w-100 mb-2']
                    ) ?>
                </div>
            </div>

            <!-- Informações da empresa -->
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-building"></i>
                        Minha Empresa
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <strong>Nome:</strong><br>
                        <span class="text-muted"><?= Html::encode($empresa->nome) ?></span>
                    </div>
                    
                    <?php if ($empresa->email): ?>
                        <div class="mb-2">
                            <strong>E-mail:</strong><br>
                            <span class="text-muted"><?= Html::encode($empresa->email) ?></span>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($empresa->telefone): ?>
                        <div class="mb-2">
                            <strong>Telefone:</strong><br>
                            <span class="text-muted"><?= Html::encode($empresa->telefone) ?></span>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($empresa->cidade): ?>
                        <div class="mb-2">
                            <strong>Cidade:</strong><br>
                            <span class="text-muted"><?= Html::encode($empresa->cidade) ?></span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Serviços disponíveis -->
            <?php if (!empty($servicos)): ?>
                <div class="card mt-4">
                    <div class="card-header bg-secondary text-white">
                        <h6 class="mb-0">
                            <i class="fas fa-concierge-bell"></i>
                            Serviços Disponíveis
                        </h6>
                    </div>
                    <div class="card-body">
                        <?php foreach (array_slice($servicos, 0, 3) as $servico): ?>
                            <div class="border-bottom pb-2 mb-2">
                                <strong><?= Html::encode($servico->nome) ?></strong><br>
                                <small class="text-success">
                                    <i class="fas fa-money-bill-wave"></i> R$ <?= number_format($servico->preco, 2, ',', '.') ?>
                                </small>
                                <?php if ($servico->duracao_minutos): ?>
                                    <small class="text-muted">
                                        | <i class="fas fa-clock"></i> <?= $servico->duracao_minutos ?> min
                                    </small>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                        
                        <?php if (count($servicos) > 3): ?>
                            <div class="text-center">
                                <?= Html::a(
                                    'Ver todos (' . count($servicos) . ')',
                                    ['/cliente/area-publica', 'empresa_id' => $empresa->id],
                                    ['class' => 'btn btn-link btn-sm']
                                ) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
