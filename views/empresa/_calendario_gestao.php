<?php
use yii\bootstrap5\Html;
use app\models\Agendamento;

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

// Função para obter classe CSS baseada no status
function obterClasseStatus($status) {
    switch($status) {
        case Agendamento::STATUS_PENDENTE:
            return 'status-pendente';
        case Agendamento::STATUS_CONFIRMADO:
            return 'status-confirmado';
        case Agendamento::STATUS_CANCELADO:
            return 'status-cancelado';
        case Agendamento::STATUS_CONCLUIDO:
            return 'status-concluido';
        default:
            return '';
    }
}

$dias = gerarDiasSemana($inicioSemana);
$agendamentosPorDia = agruparAgendamentosPorDia($agendamentosSemana);
$semanaAnterior = date('Y-m-d', strtotime($inicioSemana . ' -7 days'));
$proximaSemana = date('Y-m-d', strtotime($inicioSemana . ' +7 days'));
?>

<style>
.calendario-gestao {
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

.estatisticas-semana {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.estatistica-item {
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    color: white;
    font-weight: 600;
    text-align: center;
    min-width: 100px;
}

.estatistica-pendente { background-color: #ffc107; }
.estatistica-confirmado { background-color: #198754; }
.estatistica-cancelado { background-color: #dc3545; }
.estatistica-concluido { background-color: #6c757d; }

.calendario-grid {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
}

.calendario-dia {
    border-right: 1px solid #dee2e6;
    min-height: 250px;
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
    border: 1px solid;
    border-radius: 0.25rem;
    padding: 0.5rem;
    margin-bottom: 0.5rem;
    font-size: 0.85rem;
    position: relative;
}

.status-pendente {
    background-color: #fff3cd;
    border-color: #ffc107;
    color: #664d03;
}

.status-confirmado {
    background-color: #d1e7dd;
    border-color: #198754;
    color: #0a3622;
}

.status-cancelado {
    background-color: #f8d7da;
    border-color: #dc3545;
    color: #721c24;
}

.status-concluido {
    background-color: #d3d3d4;
    border-color: #6c757d;
    color: #495057;
}

.agendamento-cliente {
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.agendamento-detalhes {
    font-size: 0.75rem;
    margin-bottom: 0.25rem;
}

.agendamento-acoes {
    display: flex;
    gap: 0.25rem;
    flex-wrap: wrap;
}

.btn-acao {
    padding: 0.125rem 0.375rem;
    font-size: 0.7rem;
    line-height: 1.2;
}

.sem-agendamentos {
    color: #6c757d;
    text-align: center;
    padding: 2rem 1rem;
    font-style: italic;
}

.status-badge {
    display: inline-block;
    padding: 0.125rem 0.375rem;
    font-size: 0.65rem;
    border-radius: 0.25rem;
    color: white;
    font-weight: 600;
    margin-bottom: 0.25rem;
}
</style>

<div class="calendario-gestao">
    <div class="calendario-header">
        <div class="calendario-navegacao">
            <?= Html::a('<i class="fas fa-chevron-left"></i> Anterior', 
                ['agendamentos', 'week' => $semanaAnterior], 
                ['class' => 'btn btn-outline-secondary btn-sm']) ?>
            
            <h3 class="calendario-titulo">
                Gestão de Agendamentos - <?= date('d/m/Y', strtotime($inicioSemana)) ?> a <?= date('d/m/Y', strtotime($fimSemana)) ?>
            </h3>
            
            <?= Html::a('Próxima <i class="fas fa-chevron-right"></i>', 
                ['agendamentos', 'week' => $proximaSemana], 
                ['class' => 'btn btn-outline-secondary btn-sm']) ?>
        </div>
        
        <div class="estatisticas-semana">
            <div class="estatistica-item estatistica-pendente">
                <div>Pendentes</div>
                <div><?= $estatisticas['pendentes'] ?></div>
            </div>
            <div class="estatistica-item estatistica-confirmado">
                <div>Confirmados</div>
                <div><?= $estatisticas['confirmados'] ?></div>
            </div>
            <div class="estatistica-item estatistica-cancelado">
                <div>Cancelados</div>
                <div><?= $estatisticas['cancelados'] ?></div>
            </div>
            <div class="estatistica-item estatistica-concluido">
                <div>Concluídos</div>
                <div><?= $estatisticas['concluidos'] ?></div>
            </div>
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
                            <div class="agendamento-item <?= obterClasseStatus($agendamento->status) ?>">
                                <div class="status-badge <?= obterClasseStatus($agendamento->status) ?>">
                                    <?= $agendamento->getStatusLabel() ?>
                                </div>
                                
                                <div class="agendamento-cliente">
                                    <?= Html::encode($agendamento->cliente->nome) ?>
                                </div>
                                
                                <div class="agendamento-detalhes">
                                    <strong><?= date('H:i', strtotime($agendamento->data_agendamento)) ?></strong><br>
                                    <small><?= Html::encode($agendamento->servico->nome) ?></small><br>
                                    <small><em><?= Html::encode($agendamento->funcionario->nome) ?></em></small>
                                </div>
                                
                                <div class="agendamento-acoes">
                                    <?php if ($agendamento->status == Agendamento::STATUS_PENDENTE): ?>
                                        <?= Html::a('Confirmar', ['confirmar-agendamento', 'id' => $agendamento->id, 'week' => $inicioSemana], [
                                            'class' => 'btn btn-success btn-acao',
                                            'data-method' => 'post',
                                            'title' => 'Confirmar agendamento'
                                        ]) ?>
                                    <?php endif; ?>
                                    
                                    <?php if ($agendamento->status != Agendamento::STATUS_CANCELADO): ?>
                                        <?= Html::a('Cancelar', ['cancelar-agendamento', 'id' => $agendamento->id, 'week' => $inicioSemana], [
                                            'class' => 'btn btn-danger btn-acao',
                                            'data-confirm' => 'Tem certeza?',
                                            'data-method' => 'post',
                                            'title' => 'Cancelar agendamento'
                                        ]) ?>
                                    <?php endif; ?>
                                </div>
                                
                                <?php if ($agendamento->observacoes): ?>
                                    <div class="agendamento-detalhes mt-1">
                                        <small><strong>Obs:</strong> <?= Html::encode($agendamento->observacoes) ?></small>
                                    </div>
                                <?php endif; ?>
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