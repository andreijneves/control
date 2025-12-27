<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Novo Agendamento - ' . $empresa->nome;
$this->params['breadcrumbs'][] = ['label' => 'Painel', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Agendamentos', 'url' => ['agendamentos']];
$this->params['breadcrumbs'][] = 'Novo Agendamento';
?>

<div class="cliente-novo-agendamento">
    <!-- Header da página -->
    <div class="jumbotron bg-primary text-white text-center p-4 rounded mb-4">
        <h1 class="display-5">
            <i class="fas fa-calendar-plus"></i>
            Novo Agendamento
        </h1>
        <p class="lead">Agende um serviço em <?= Html::encode($empresa->nome) ?></p>
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
                                ['class' => 'btn btn-light border h-100 w-100']
                            ) ?>
                        </div>
                        <div class="col-md-4 mb-3">
                            <?= Html::a(
                                '<i class="fas fa-calendar-plus fa-3x text-primary mb-2"></i><br><strong>Novo Agendamento</strong><br><small>Agendar serviço</small>',
                                ['/cliente/novo-agendamento'],
                                ['class' => 'btn btn-light border h-100 w-100 active']
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
        <!-- Coluna principal - Formulário de agendamento -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-calendar-plus"></i>
                        Dados do Agendamento
                    </h3>
                </div>
                <div class="card-body">
                    <?php if (empty($servicos)): ?>
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            <strong>Ops!</strong> Esta empresa ainda não possui serviços cadastrados.
                            <hr>
                            <p class="mb-0">Entre em contato com a empresa para mais informações sobre os serviços disponíveis.</p>
                        </div>
                    <?php else: ?>
                        <?php $form = ActiveForm::begin(['id' => 'form-novo-agendamento']); ?>
                        
                        <div class="row">
                            <!-- Serviço -->
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">
                                        <i class="fas fa-concierge-bell text-primary"></i>
                                        Serviço *
                                    </label>
                                    <select name="Agendamento[servico_id]" class="form-control" required>
                                        <option value="">Escolha um serviço</option>
                                        <?php foreach ($servicos as $servico): ?>
                                            <option value="<?= $servico->id ?>" data-preco="<?= $servico->preco ?>" data-duracao="<?= $servico->duracao_minutos ?>">
                                                <?= Html::encode($servico->nome) ?> - R$ <?= number_format($servico->preco, 2, ',', '.') ?>
                                                <?php if ($servico->duracao_minutos): ?>
                                                    (<?= $servico->duracao_minutos ?> min)
                                                <?php endif; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="form-text">Selecione o serviço que deseja agendar</div>
                                </div>
                            </div>
                            
                            <!-- Profissional -->
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">
                                        <i class="fas fa-user text-info"></i>
                                        Profissional *
                                    </label>
                                    <select name="Agendamento[funcionario_id]" class="form-control" required>
                                        <option value="">Escolha um profissional</option>
                                        <?php foreach ($funcionarios as $funcionario): ?>
                                            <option value="<?= $funcionario->id ?>">
                                                <?= Html::encode($funcionario->nome) ?>
                                                <?php if ($funcionario->cargo): ?>
                                                    - <?= Html::encode($funcionario->cargo) ?>
                                                <?php endif; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="form-text">Escolha o profissional de sua preferência</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <!-- Data -->
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">
                                        <i class="fas fa-calendar text-warning"></i>
                                        Data do Agendamento *
                                    </label>
                                    <input type="date" 
                                           name="Agendamento[data]" 
                                           class="form-control" 
                                           required
                                           min="<?= date('Y-m-d') ?>"
                                           max="<?= date('Y-m-d', strtotime('+3 months')) ?>">
                                    <div class="form-text">Escolha uma data futura (até 3 meses)</div>
                                </div>
                            </div>
                            
                            <!-- Horário -->
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">
                                        <i class="fas fa-clock text-success"></i>
                                        Horário *
                                    </label>
                                    <input type="time" 
                                           name="Agendamento[horario]" 
                                           class="form-control" 
                                           required
                                           min="08:00"
                                           max="18:00">
                                    <div class="form-text">Horário de atendimento: 08:00 às 18:00</div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Observações -->
                        <div class="form-group mb-4">
                            <label class="form-label">
                                <i class="fas fa-comment text-secondary"></i>
                                Observações (opcional)
                            </label>
                            <textarea name="Agendamento[observacoes]" 
                                      class="form-control" 
                                      rows="3" 
                                      placeholder="Alguma informação adicional que gostaria de compartilhar..."></textarea>
                            <div class="form-text">Descreva algum detalhe importante sobre seu agendamento</div>
                        </div>
                        
                        <!-- Resumo dinâmico -->
                        <div id="resumo-agendamento" class="alert alert-info d-none">
                            <h6><i class="fas fa-clipboard-list"></i> Resumo do Agendamento:</h6>
                            <div id="resumo-conteudo"></div>
                        </div>
                        
                        <!-- Botões -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-success btn-lg px-5 me-3">
                                <i class="fas fa-calendar-check"></i>
                                Confirmar Agendamento
                            </button>
                            
                            <?= Html::a(
                                '<i class="fas fa-times"></i> Cancelar',
                                ['/cliente/agendamentos'],
                                ['class' => 'btn btn-secondary btn-lg px-4']
                            ) ?>
                        </div>
                        
                        <?php ActiveForm::end(); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Sidebar - Informações úteis -->
        <div class="col-lg-4">
            <!-- Horários de funcionamento -->
            <?php if (!empty($horarios)): ?>
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h6 class="mb-0">
                            <i class="fas fa-clock"></i>
                            Horários de Funcionamento
                        </h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm table-borderless mb-0">
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
                                    <td class="fw-bold" style="width: 40px;"><?= $nomeDia ?></td>
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
                    </div>
                </div>
            <?php endif; ?>

            <!-- Dicas importantes -->
            <div class="card mt-4">
                <div class="card-header bg-warning text-dark">
                    <h6 class="mb-0">
                        <i class="fas fa-lightbulb"></i>
                        Dicas Importantes
                    </h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled small mb-0">
                        <li class="mb-2">
                            <i class="fas fa-check text-success"></i>
                            <strong>Confirmação:</strong> Seu agendamento ficará pendente até a empresa confirmar
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-bell text-info"></i>
                            <strong>Notificações:</strong> Você receberá atualizações sobre o status
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-calendar-times text-warning"></i>
                            <strong>Cancelamento:</strong> Use o formulário de contato para cancelar
                        </li>
                        <li>
                            <i class="fas fa-clock text-primary"></i>
                            <strong>Pontualidade:</strong> Chegue alguns minutos antes do horário
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Contato rápido -->
            <div class="card mt-4">
                <div class="card-header bg-secondary text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-headset"></i>
                        Precisa de Ajuda?
                    </h6>
                </div>
                <div class="card-body text-center">
                    <p class="small mb-3">Dúvidas sobre horários disponíveis ou serviços?</p>
                    
                    <?php if ($empresa->telefone): ?>
                        <div class="mb-2">
                            <i class="fas fa-phone text-success"></i>
                            <strong><?= Html::encode($empresa->telefone) ?></strong>
                        </div>
                    <?php endif; ?>
                    
                    <div class="mt-3">
                        <?= Html::a(
                            '<i class="fas fa-envelope"></i> Enviar Mensagem',
                            ['/cliente/agendamentos'],
                            ['class' => 'btn btn-outline-secondary btn-sm']
                        ) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('form-novo-agendamento');
    const servicoSelect = form.querySelector('select[name="Agendamento[servico_id]"]');
    const funcionarioSelect = form.querySelector('select[name="Agendamento[funcionario_id]"]');
    const dataInput = form.querySelector('input[name="Agendamento[data]"]');
    const horarioInput = form.querySelector('input[name="Agendamento[horario]"]');
    const resumoDiv = document.getElementById('resumo-agendamento');
    const resumoConteudo = document.getElementById('resumo-conteudo');

    function atualizarResumo() {
        const servico = servicoSelect.options[servicoSelect.selectedIndex];
        const funcionario = funcionarioSelect.options[funcionarioSelect.selectedIndex];
        const data = dataInput.value;
        const horario = horarioInput.value;

        if (servico.value && funcionario.value && data && horario) {
            const dataFormatada = new Date(data + 'T00:00:00').toLocaleDateString('pt-BR');
            const preco = servico.getAttribute('data-preco');
            const duracao = servico.getAttribute('data-duracao');
            
            let html = `
                <strong>Serviço:</strong> ${servico.text}<br>
                <strong>Profissional:</strong> ${funcionario.text}<br>
                <strong>Data:</strong> ${dataFormatada}<br>
                <strong>Horário:</strong> ${horario}
            `;
            
            if (duracao) {
                html += `<br><strong>Duração:</strong> ${duracao} minutos`;
            }
            
            resumoConteudo.innerHTML = html;
            resumoDiv.classList.remove('d-none');
        } else {
            resumoDiv.classList.add('d-none');
        }
    }

    // Validação do formulário
    form.addEventListener('submit', function(e) {
        let isValid = true;
        const required = form.querySelectorAll('[required]');
        
        required.forEach(function(field) {
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                isValid = false;
            } else {
                field.classList.remove('is-invalid');
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            alert('Por favor, preencha todos os campos obrigatórios.');
            return;
        }
        
        // Validação de horário
        const horario = horarioInput.value;
        if (horario < '08:00' || horario > '18:00') {
            e.preventDefault();
            alert('Por favor, escolha um horário entre 08:00 e 18:00.');
            horarioInput.focus();
            return;
        }
    });

    // Atualizar resumo em tempo real
    [servicoSelect, funcionarioSelect, dataInput, horarioInput].forEach(element => {
        element.addEventListener('change', atualizarResumo);
    });
});
</script>