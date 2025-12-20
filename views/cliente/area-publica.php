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

        <!-- Coluna 2: Formulário de agendamento -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-calendar-plus"></i>
                        <?php if (Yii::$app->user->isGuest): ?>
                            Cadastre-se e Agende seu Serviço
                        <?php else: ?>
                            Agendar Serviço
                        <?php endif; ?>
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (empty($servicos)): ?>
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            Esta empresa ainda não possui serviços cadastrados.
                        </div>
                    <?php else: ?>
                        <?php $form = ActiveForm::begin(['id' => 'form-agendamento']); ?>
                        
                        <?php if (Yii::$app->user->isGuest): ?>
                            <!-- Cadastro rápido -->
                            <h6 class="text-primary border-bottom pb-2 mb-3">
                                <i class="fas fa-user-plus"></i> Seus Dados
                            </h6>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Nome Completo *</label>
                                        <input type="text" name="Cliente[nome]" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">E-mail *</label>
                                        <input type="email" name="Cliente[email]" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Telefone *</label>
                                        <input type="tel" name="Cliente[telefone]" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Senha *</label>
                                        <input type="password" name="Cliente[senha]" class="form-control" required minlength="6">
                                    </div>
                                </div>
                            </div>
                            
                            <hr class="my-4">
                        <?php endif; ?>
                        
                        <!-- Agendamento -->
                        <h6 class="text-success border-bottom pb-2 mb-3">
                            <i class="fas fa-calendar"></i> Dados do Agendamento
                        </h6>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Serviço *</label>
                                    <select name="Agendamento[servico_id]" class="form-control" required>
                                        <option value="">Escolha um serviço</option>
                                        <?php foreach ($servicos as $servico): ?>
                                            <option value="<?= $servico->id ?>">
                                                <?= Html::encode($servico->nome) ?> - R$ <?= number_format($servico->preco, 2, ',', '.') ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Profissional *</label>
                                    <select name="Agendamento[funcionario_id]" class="form-control" required>
                                        <option value="">Escolha um profissional</option>
                                        <?php foreach ($funcionarios as $funcionario): ?>
                                            <option value="<?= $funcionario->id ?>">
                                                <?= Html::encode($funcionario->nome) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Data *</label>
                                    <input type="date" 
                                           name="Agendamento[data_agendamento]" 
                                           class="form-control" 
                                           required
                                           min="<?= date('Y-m-d') ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Horário *</label>
                                    <input type="time" 
                                           name="Agendamento[horario]" 
                                           class="form-control" 
                                           required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-success btn-lg px-5">
                                <i class="fas fa-calendar-check"></i>
                                <?php if (Yii::$app->user->isGuest): ?>
                                    Cadastrar e Agendar
                                <?php else: ?>
                                    Confirmar Agendamento
                                <?php endif; ?>
                            </button>
                        </div>
                        
                            <div class="text-center mt-3">
                                <small class="text-muted">
                                    Já tem conta na empresa <?= Html::encode($empresa->nome) ?>? 
                                    <?= Html::a('Faça login aqui', ['/cliente/login-cliente'], ['class' => 'fw-bold']) ?>
                                </small>
                            </div>
                        
                        <?php ActiveForm::end(); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Combinar data e horário em data_agendamento
    const form = document.getElementById('form-agendamento');
    if (form) {
        form.addEventListener('submit', function(e) {
            const dataInput = form.querySelector('input[name="Agendamento[data_agendamento]"]');
            const horarioInput = form.querySelector('input[name="Agendamento[horario]"]');
            
            if (dataInput && horarioInput && dataInput.value && horarioInput.value) {
                const dataHorario = dataInput.value + ' ' + horarioInput.value + ':00';
                dataInput.value = dataHorario;
                horarioInput.remove();
            }
        });
    }
});
</script>