<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Meus Agendamentos - ' . $empresa->nome;
$this->params['breadcrumbs'][] = ['label' => 'Painel', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Agendamentos';
?>

<div class="cliente-agendamentos">
    <!-- Header da página -->
    <div class="jumbotron bg-success text-white text-center p-4 rounded mb-4">
        <h1 class="display-5">
            <i class="fas fa-calendar-alt"></i>
            Meus Agendamentos
        </h1>
        <p class="lead">Gerencie seus agendamentos em <?= Html::encode($empresa->nome) ?></p>
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
                                ['class' => 'btn btn-light border h-100 w-100']
                            ) ?>
                        </div>
                        <div class="col-md-4 mb-3">
                            <?= Html::a(
                                '<i class="fas fa-history fa-3x text-success mb-2"></i><br><strong>Histórico</strong><br><small>Meus agendamentos</small>',
                                ['/cliente/agendamentos'],
                                ['class' => 'btn btn-light border h-100 w-100 active']
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

    <!-- Mensagens Flash -->
    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i>
            <?= Yii::$app->session->getFlash('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (Yii::$app->session->hasFlash('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i>
            <?= Yii::$app->session->getFlash('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="row">
        <!-- Coluna principal - Lista de agendamentos -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-history"></i>
                        Histórico de Agendamentos
                    </h3>
                </div>
                <div class="card-body">
                    <?php if (!empty($agendamentos)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Data/Hora</th>
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
                                                <i class="fas fa-concierge-bell text-primary"></i>
                                                <?= Html::encode($agendamento->servico->nome ?? 'N/A') ?>
                                            </td>
                                            <td>
                                                <i class="fas fa-user text-info"></i>
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
                        <div class="text-center py-5">
                            <i class="fas fa-calendar-times fa-4x text-muted mb-3"></i>
                            <h4>Nenhum agendamento encontrado</h4>
                            <p class="text-muted">Você ainda não fez nenhum agendamento com <?= Html::encode($empresa->nome) ?>.</p>
                            <?= Html::a(
                                '<i class="fas fa-calendar-plus"></i> Fazer meu primeiro agendamento',
                                ['/cliente/area-publica', 'empresa_id' => $empresa->id],
                                ['class' => 'btn btn-success btn-lg mt-3']
                            ) ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Sidebar - Ações e Contato -->
        <div class="col-lg-4">
            <!-- Ações rápidas -->
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-plus-circle"></i>
                        Novo Agendamento
                    </h5>
                </div>
                <div class="card-body text-center">
                    <i class="fas fa-calendar-plus fa-3x text-success mb-3"></i>
                    <h6>Quer agendar um novo serviço?</h6>
                    <p class="text-muted small mb-3">Acesse a página dedicada para criar um novo agendamento</p>
                    
                    <?= Html::a(
                        '<i class="fas fa-calendar-plus"></i> Criar Novo Agendamento',
                        ['/cliente/novo-agendamento'],
                        ['class' => 'btn btn-success btn-lg w-100']
                    ) ?>
                </div>
            </div>

            <!-- Contato com a empresa -->
            <div class="card mt-4">
                <div class="card-header bg-warning text-dark">
                    <h6 class="mb-0">
                        <i class="fas fa-envelope"></i>
                        Contato com a Empresa
                    </h6>
                </div>
                <div class="card-body">
                    <p class="small text-muted mb-3">
                        Precisa falar com <?= Html::encode($empresa->nome) ?>? 
                        Use o formulário abaixo para enviar uma mensagem direta.
                    </p>
                    
                    <form method="post" action="<?= \yii\helpers\Url::to(['/cliente/enviar-contato']) ?>">
                        <?= Html::hiddenInput('empresa_id', $empresa->id) ?>
                        
                        <div class="form-group mb-3">
                            <label class="form-label small">Assunto *</label>
                            <select name="assunto" class="form-control form-control-sm" required>
                                <option value="">Selecione o assunto</option>
                                <option value="Dúvida sobre agendamento">Dúvida sobre agendamento</option>
                                <option value="Cancelamento de agendamento">Cancelamento de agendamento</option>
                                <option value="Reagendamento">Reagendamento</option>
                                <option value="Dúvida sobre serviços">Dúvida sobre serviços</option>
                                <option value="Outros">Outros</option>
                            </select>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label class="form-label small">Mensagem *</label>
                            <textarea name="mensagem" class="form-control form-control-sm" rows="4" required placeholder="Digite sua mensagem..."></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-warning btn-sm w-100">
                            <i class="fas fa-paper-plane"></i>
                            Enviar Mensagem
                        </button>
                    </form>
                </div>
            </div>

            <!-- Informações da empresa -->
            <div class="card mt-4">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-building"></i>
                        Informações de Contato
                    </h6>
                </div>
                <div class="card-body">
                    <?php if ($empresa->telefone): ?>
                        <div class="mb-2">
                            <small class="text-muted">Telefone:</small><br>
                            <strong><?= Html::encode($empresa->telefone) ?></strong>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($empresa->email): ?>
                        <div class="mb-2">
                            <small class="text-muted">E-mail:</small><br>
                            <strong><?= Html::encode($empresa->email) ?></strong>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($empresa->endereco): ?>
                        <div class="mb-2">
                            <small class="text-muted">Endereço:</small><br>
                            <small><?= Html::encode($empresa->endereco) ?></small>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Informações úteis -->
            <div class="card mt-4">
                <div class="card-header bg-secondary text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-info-circle"></i>
                        Informações Úteis
                    </h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled small">
                        <li class="mb-2"><i class="fas fa-check text-success"></i> Agendamentos ficam pendentes até confirmação da empresa</li>
                        <li class="mb-2"><i class="fas fa-clock text-info"></i> Você será notificado sobre mudanças de status</li>
                        <li class="mb-2"><i class="fas fa-phone text-primary"></i> Para cancelar, use o formulário de contato</li>
                        <li><i class="fas fa-calendar text-warning"></i> Para reagendar, entre em contato com a empresa</li>
                    </ul>
                </div>
            </div>
        </div>
</div>