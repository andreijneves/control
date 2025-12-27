<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = $empresa->nome . ' - Agendamentos Online';
$this->params['breadcrumbs'][] = $empresa->nome;
?>

<div class="area-publica-empresa">
    <!-- Header da empresa -->
    <div class="jumbotron bg-primary text-white text-center p-4 rounded mb-4">
        <h1 class="display-5">
            <i class="fas fa-building"></i>
            <?= Html::encode($empresa->nome) ?>
        </h1>
        <p class="lead">Agende seus serviços online de forma rápida e fácil</p>
        
        <?php if ($empresa->telefone || $empresa->email): ?>
            <div class="mt-3">
                <?php if ($empresa->telefone): ?>
                    <span class="badge bg-light text-dark me-2">
                        <i class="fas fa-phone"></i> <?= Html::encode($empresa->telefone) ?>
                    </span>
                <?php endif; ?>
                
                <?php if ($empresa->cidade): ?>
                    <span class="badge bg-light text-dark">
                        <i class="fas fa-map-marker-alt"></i> <?= Html::encode($empresa->cidade) ?>
                    </span>
                <?php endif; ?>
            </div>
        <?php endif; ?>
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

    <?php if (Yii::$app->session->hasFlash('info')): ?>
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <i class="fas fa-info-circle"></i>
            <?= Yii::$app->session->getFlash('info') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="row">
        <!-- Coluna 1: Informações da empresa -->
        <div class="col-lg-4 mb-4">
            <!-- Horários -->
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-clock"></i>
                        Horários de Funcionamento
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($horarios)): ?>
                        <table class="table table-sm table-borderless">
                            <?php
                            $horariosPorDia = [];
                            foreach ($horarios as $horario) {
                                $horariosPorDia[$horario->dia_semana] = $horario;
                            }
                            
                            $diasSemana = [
                                1 => 'Seg', 2 => 'Ter', 3 => 'Qua', 4 => 'Qui', 
                                5 => 'Sex', 6 => 'Sáb', 0 => 'Dom'
                            ];
                            
                            foreach ($diasSemana as $dia => $nomeDia):
                                $horario = $horariosPorDia[$dia] ?? null;
                            ?>
                                <tr>
                                    <td class="fw-bold"><?= $nomeDia ?></td>
                                    <td>
                                        <?php if ($horario && $horario->disponivel): ?>
                                            <small class="text-success">
                                                <?= substr($horario->hora_inicio, 0, 5) ?> - <?= substr($horario->hora_fim, 0, 5) ?>
                                            </small>
                                        <?php else: ?>
                                            <small class="text-muted">Fechado</small>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    <?php else: ?>
                        <p class="text-muted small">Horários não informados</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Serviços -->
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-concierge-bell"></i>
                        Nossos Serviços
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($servicos)): ?>
                        <?php foreach ($servicos as $servico): ?>
                            <div class="border-bottom pb-2 mb-2">
                                <h6 class="text-primary mb-1"><?= Html::encode($servico->nome) ?></h6>
                                <div class="d-flex justify-content-between">
                                    <strong class="text-success">
                                        R$ <?= number_format($servico->preco, 2, ',', '.') ?>
                                    </strong>
                                    <?php if ($servico->duracao_minutos): ?>
                                        <small class="text-muted">
                                            <?= $servico->duracao_minutos ?> min
                                        </small>
                                    <?php endif; ?>
                                </div>
                                <?php if ($servico->descricao): ?>
                                    <small class="text-muted"><?= Html::encode($servico->descricao) ?></small>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-muted">Nenhum serviço disponível no momento.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Coluna 2: Sistema de Login -->
        <div class="col-lg-8">
            <?php if (Yii::$app->user->isGuest): ?>
                <!-- Formulário de Login -->
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-sign-in-alt"></i>
                            Área do Cliente
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Coluna Login -->
                            <div class="col-md-6">
                                <h6 class="text-primary border-bottom pb-2 mb-3">
                                    <i class="fas fa-user"></i> Já sou cliente
                                </h6>
                                
                                <p class="text-muted small mb-3">Entre com seus dados de acesso:</p>
                                
                                <div class="text-center">
                                    <?= Html::a(
                                        '<i class="fas fa-sign-in-alt"></i> Fazer Login',
                                        ['/cliente/login-cliente', 'empresa_id' => $empresa->id],
                                        ['class' => 'btn btn-primary btn-lg w-100 mb-3']
                                    ) ?>
                                </div>
                                
                                <p class="text-center small text-muted">
                                    Acesse sua conta para ver seus agendamentos<br>
                                    e solicitar novos serviços.
                                </p>
                            </div>
                            
                            <!-- Coluna Cadastro -->
                            <div class="col-md-6">
                                <h6 class="text-success border-bottom pb-2 mb-3">
                                    <i class="fas fa-user-plus"></i> Primeira vez aqui?
                                </h6>
                                
                                <p class="text-muted small mb-3">Crie sua conta na empresa:</p>
                                
                                <div class="text-center">
                                    <?= Html::a(
                                        '<i class="fas fa-user-plus"></i> Criar Conta',
                                        ['/cliente/cadastro', 'empresa_id' => $empresa->id],
                                        ['class' => 'btn btn-success btn-lg w-100 mb-3']
                                    ) ?>
                                </div>
                                
                                <p class="text-center small text-muted">
                                    Cadastre-se gratuitamente para<br>
                                    agendar nossos serviços online.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <!-- Cliente logado -->
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-user-check"></i>
                            Bem-vindo, <?= Html::encode(Yii::$app->user->identity->nome_completo) ?>!
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info text-center">
                            <i class="fas fa-info-circle fa-2x mb-3"></i>
                            <h5>Você está logado como cliente</h5>
                            <p class="mb-3">Acesse suas opções através dos links abaixo:</p>
                            
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <?= Html::a(
                                        '<i class="fas fa-tachometer-alt fa-2x mb-2"></i><br><strong>Meu Painel</strong><br><small>Informações da empresa</small>',
                                        ['/cliente/index'],
                                        ['class' => 'btn btn-outline-primary w-100 h-100']
                                    ) ?>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <?= Html::a(
                                        '<i class="fas fa-calendar-alt fa-2x mb-2"></i><br><strong>Meus Agendamentos</strong><br><small>Ver histórico e agendar</small>',
                                        ['/cliente/agendamentos'],
                                        ['class' => 'btn btn-outline-success w-100 h-100']
                                    ) ?>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <?= Html::a(
                                        '<i class="fas fa-sign-out-alt fa-2x mb-2"></i><br><strong>Sair</strong><br><small>Logout da conta</small>',
                                        ['/site/logout'],
                                        [
                                            'class' => 'btn btn-outline-danger w-100 h-100',
                                            'data-method' => 'post',
                                            'data-confirm' => 'Deseja realmente sair?'
                                        ]
                                    ) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            
            <!-- Informações adicionais -->
            <div class="card mt-4">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-info-circle"></i>
                        Como funciona?
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3 mb-3">
                            <i class="fas fa-user-plus fa-2x text-primary mb-2"></i>
                            <h6>1. Cadastro</h6>
                            <small class="text-muted">Crie sua conta gratuitamente</small>
                        </div>
                        <div class="col-md-3 mb-3">
                            <i class="fas fa-sign-in-alt fa-2x text-success mb-2"></i>
                            <h6>2. Login</h6>
                            <small class="text-muted">Acesse sua área pessoal</small>
                        </div>
                        <div class="col-md-3 mb-3">
                            <i class="fas fa-calendar-plus fa-2x text-warning mb-2"></i>
                            <h6>3. Agende</h6>
                            <small class="text-muted">Escolha serviço e horário</small>
                        </div>
                        <div class="col-md-3 mb-3">
                            <i class="fas fa-check-circle fa-2x text-info mb-2"></i>
                            <h6>4. Confirmação</h6>
                            <small class="text-muted">Receba a confirmação</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>