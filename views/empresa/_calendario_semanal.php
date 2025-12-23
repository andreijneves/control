<?php
use yii\bootstrap5\Html;

// Função para gerar os dias da semana
function gerarDiasSemana($inicioSemana) {
    $dias = [];
    for ($i = 0; $i < 7; $i++) {
        $data = date('Y-m-d', strtotime($inicioSemana . " +{$i} days"));
        $dias[] = [
            'data' => $data,
            'nome' => ucfirst(strftime('%a', strtotime($data))),
            'numero' => date('d', strtotime($data)),
            'hoje' => $data === date('Y-m-d'),
        ];
    }
    return $dias;
}

// Função para agrupar agendamentos por dia
function agruparAgendamentosPorDia($agendamentos) {
    $agendamentosPorDia = [];
    foreach ($agendamentos as $agendamento) {
        $data = date('Y-m-d', strtotime($agendamento->data_agendamento));
        if (!isset($agendamentosPorDia[$data])) {
            $agendamentosPorDia[$data] = [];
        }
        $agendamentosPorDia[$data][] = $agendamento;
    }
    return $agendamentosPorDia;
}

$dias = gerarDiasSemana($inicioSemana);
$agendamentosPorDia = agruparAgendamentosPorDia($agendamentosSemana);
$semanaAnterior = date('Y-m-d', strtotime($inicioSemana . ' -7 days'));
$proximaSemana = date('Y-m-d', strtotime($inicioSemana . ' +7 days'));
?>

<style>
.calendario-semanal {
    border: 1px solid #dee2e6;
    border-radius: 0.375rem;
    overflow: hidden;
}

.calendario-header {
    background-color: #f8f9fa;
    padding: 1rem;
    border-bottom: 1px solid #dee2e6;
}

.calendario-navegacao {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.calendario-titulo {
    font-size: 1.25rem;
    font-weight: 600;
    margin: 0;
}

.calendario-grid {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
}

.calendario-dia {
    border-right: 1px solid #dee2e6;
    min-height: 200px;
    position: relative;
}

.calendario-dia:last-child {
    border-right: none;
}

.dia-header {
    background-color: #f8f9fa;
    padding: 0.5rem;
    border-bottom: 1px solid #dee2e6;
    text-align: center;
    font-weight: 600;
}

.dia-header.hoje {
    background-color: #0d6efd;
    color: white;
}

.dia-conteudo {
    padding: 0.5rem;
}

.agendamento-item {
    background-color: #e7f3ff;
    border: 1px solid #0d6efd;
    border-radius: 0.25rem;
    padding: 0.25rem 0.5rem;
    margin-bottom: 0.25rem;
    font-size: 0.8rem;
    cursor: pointer;
    transition: background-color 0.2s;
}

.agendamento-item:hover {
    background-color: #cce7ff;
}

.agendamento-cliente {
    font-weight: 600;
    color: #0d6efd;
}

.agendamento-horario {
    color: #6c757d;
    font-size: 0.75rem;
}

.agendamento-servico {
    color: #495057;
    font-size: 0.75rem;
}

.agendamento-funcionario {
    color: #6c757d;
    font-size: 0.75rem;
    font-weight: 500;
}

.agendamento-funcionario i {
    margin-right: 0.25rem;
}

.sem-agendamentos {
    color: #6c757d;
    text-align: center;
    padding: 1rem;
    font-style: italic;
}
</style>

<div class="calendario-semanal">
    <div class="calendario-header">
        <div class="calendario-navegacao">
            <?= Html::a('<i class="fas fa-chevron-left"></i> Anterior', 
                ['index', 'week' => $semanaAnterior], 
                ['class' => 'btn btn-outline-secondary btn-sm']) ?>
            
            <h3 class="calendario-titulo">
                Calendário Semanal - <?= date('d/m/Y', strtotime($inicioSemana)) ?> a <?= date('d/m/Y', strtotime($fimSemana)) ?>
            </h3>
            
            <?= Html::a('Próxima <i class="fas fa-chevron-right"></i>', 
                ['index', 'week' => $proximaSemana], 
                ['class' => 'btn btn-outline-secondary btn-sm']) ?>
        </div>
    </div>
    
    <div class="calendario-grid">
        <?php foreach ($dias as $dia): ?>
            <div class="calendario-dia">
                <div class="dia-header <?= $dia['hoje'] ? 'hoje' : '' ?>">
                    <div><?= $dia['nome'] ?></div>
                    <div><?= $dia['numero'] ?></div>
                </div>
                
                <div class="dia-conteudo">
                    <?php if (isset($agendamentosPorDia[$dia['data']])): ?>
                        <?php foreach ($agendamentosPorDia[$dia['data']] as $agendamento): ?>
                            <div class="agendamento-item" 
                                 title="<?= Html::encode($agendamento->cliente->nome . ' - ' . $agendamento->servico->nome . ' com ' . $agendamento->funcionario->nome) ?>"
                                 data-bs-toggle="tooltip">
                                <div class="agendamento-cliente">
                                    <?= Html::encode($agendamento->cliente->nome) ?>
                                </div>
                                <div class="agendamento-horario">
                                    <?= date('H:i', strtotime($agendamento->data_agendamento)) ?>
                                </div>
                                <div class="agendamento-servico">
                                    <?= Html::encode($agendamento->servico->nome) ?>
                                </div>
                                <div class="agendamento-funcionario">
                                    <i class="fas fa-user"></i> <?= Html::encode($agendamento->funcionario->nome) ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="sem-agendamentos">
                            <small>Nenhum agendamento</small>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
// Ativar tooltips
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>