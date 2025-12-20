<?php

use yii\bootstrap5\Html;

$this->title = $empresa->nome . ' - Perfil da Empresa';
$this->params['breadcrumbs'][] = ['label' => 'Área Pública', 'url' => ['area-publica']];
$this->params['breadcrumbs'][] = $empresa->nome;
?>

<div class="perfil-empresa">
    <!-- Header da empresa -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h1 class="card-title mb-0">
                <i class="fas fa-building"></i> 
                <?= Html::encode($empresa->nome) ?>
            </h1>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <?php if ($empresa->descricao): ?>
                        <h5>Sobre a Empresa</h5>
                        <p class="text-muted"><?= Html::encode($empresa->descricao) ?></p>
                    <?php endif; ?>
                    
                    <h5>Informações de Contato</h5>
                    <ul class="list-unstyled">
                        <?php if ($empresa->email): ?>
                            <li class="mb-2">
                                <i class="fas fa-envelope text-primary"></i> 
                                <strong>E-mail:</strong> 
                                <a href="mailto:<?= Html::encode($empresa->email) ?>">
                                    <?= Html::encode($empresa->email) ?>
                                </a>
                            </li>
                        <?php endif; ?>
                        
                        <?php if ($empresa->telefone): ?>
                            <li class="mb-2">
                                <i class="fas fa-phone text-primary"></i> 
                                <strong>Telefone:</strong> 
                                <a href="tel:<?= Html::encode($empresa->telefone) ?>">
                                    <?= Html::encode($empresa->telefone) ?>
                                </a>
                            </li>
                        <?php endif; ?>
                        
                        <?php if ($empresa->endereco): ?>
                            <li class="mb-2">
                                <i class="fas fa-map-marker-alt text-primary"></i> 
                                <strong>Endereço:</strong> 
                                <?= Html::encode($empresa->endereco) ?>
                            </li>
                        <?php endif; ?>
                        
                        <?php if ($empresa->cidade): ?>
                            <li class="mb-2">
                                <i class="fas fa-city text-primary"></i> 
                                <strong>Cidade:</strong> 
                                <?= Html::encode($empresa->cidade) ?>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
                
                <div class="col-md-6">
                    <h5>Horários de Funcionamento</h5>
                    <?php if (!empty($horarios)): ?>
                        <table class="table table-sm">
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
                                0 => 'Domingo',
                            ];
                            
                            foreach ($diasSemana as $dia => $nomeDia):
                                $horario = $horariosPorDia[$dia] ?? null;
                            ?>
                                <tr>
                                    <td class="fw-bold"><?= $nomeDia ?></td>
                                    <td>
                                        <?php if ($horario && $horario->disponivel): ?>
                                            <span class="text-success">
                                                <i class="fas fa-clock"></i>
                                                <?= substr($horario->hora_inicio, 0, 5) ?> - <?= substr($horario->hora_fim, 0, 5) ?>
                                            </span>
                                        <?php else: ?>
                                            <span class="text-muted">
                                                <i class="fas fa-times"></i> Fechado
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    <?php else: ?>
                        <p class="text-muted">Horários não informados.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Serviços oferecidos -->
    <div class="card">
        <div class="card-header bg-secondary text-white">
            <h3 class="card-title mb-0">
                <i class="fas fa-concierge-bell"></i> 
                Serviços Oferecidos
            </h3>
        </div>
        <div class="card-body">
            <?php if (empty($servicos)): ?>
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle fa-2x mb-3"></i>
                    <h4>Nenhum serviço cadastrado</h4>
                    <p>Esta empresa ainda não cadastrou seus serviços.</p>
                </div>
            <?php else: ?>
                <div class="row">
                    <?php foreach ($servicos as $servico): ?>
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card h-100 border-light">
                                <div class="card-body">
                                    <h5 class="card-title text-primary">
                                        <i class="fas fa-star"></i> 
                                        <?= Html::encode($servico->nome) ?>
                                    </h5>
                                    
                                    <?php if ($servico->descricao): ?>
                                        <p class="card-text text-muted">
                                            <?= Html::encode($servico->descricao) ?>
                                        </p>
                                    <?php endif; ?>
                                    
                                    <div class="row">
                                        <div class="col-6">
                                            <strong class="text-success">
                                                <i class="fas fa-money-bill-wave"></i>
                                                R$ <?= number_format($servico->preco, 2, ',', '.') ?>
                                            </strong>
                                        </div>
                                        
                                        <?php if ($servico->duracao_minutos): ?>
                                            <div class="col-6 text-end">
                                                <span class="text-muted">
                                                    <i class="fas fa-clock"></i>
                                                    <?= $servico->duracao_minutos ?> min
                                                </span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="alert alert-warning mt-4">
                    <h5><i class="fas fa-calendar-alt"></i> Quer agendar um serviço?</h5>
                    <p class="mb-3">Para fazer agendamentos, você precisa estar logado como cliente.</p>
                    
                    <?php if (Yii::$app->user->isGuest): ?>
                        <?= Html::a('👤 Cadastrar-se como Cliente', ['/cliente/cadastro'], ['class' => 'btn btn-primary me-2']) ?>
                        <?= Html::a('🔐 Fazer Login', ['/cliente/login-cliente'], ['class' => 'btn btn-outline-primary']) ?>
                    <?php elseif (Yii::$app->user->identity->isCliente()): ?>
                        <?= Html::a('📅 Fazer Agendamento', ['/cliente/agendar', 'empresa_id' => $empresa->id], ['class' => 'btn btn-success']) ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Navegação -->
    <div class="mt-4">
        <?= Html::a('← Voltar para Área Pública', ['area-publica'], ['class' => 'btn btn-secondary']) ?>
    </div>
</div>