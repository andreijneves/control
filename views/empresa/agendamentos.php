<?php

use yii\bootstrap5\Html;
use yii\grid\GridView;
use app\models\Agendamento;

$this->title = 'Gestão de Agendamentos';
$this->params['breadcrumbs'][] = $this->title;

// Parâmetros atuais para preservar na alternância de views
$currentParams = Yii::$app->request->queryParams;
$weekParam = Yii::$app->request->get('week');
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><?= Html::encode($this->title) ?></h1>
    
    <!-- Botões de alternância de visualização -->
    <div class="btn-group" role="group" aria-label="Tipo de visualização">
        <?= Html::a('<i class="fas fa-calendar"></i> Calendário', 
            ['agendamentos', 'view' => 'calendario'] + ($weekParam ? ['week' => $weekParam] : []), 
            ['class' => 'btn ' . ($tipoView === 'calendario' ? 'btn-primary' : 'btn-outline-primary')]) ?>
        <?= Html::a('<i class="fas fa-list"></i> Lista', 
            ['agendamentos', 'view' => 'lista'], 
            ['class' => 'btn ' . ($tipoView === 'lista' ? 'btn-primary' : 'btn-outline-primary')]) ?>
    </div>
</div>

<?php if ($tipoView === 'lista'): ?>
    <!-- Visualização em Lista -->
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => ['class' => 'table table-striped table-hover'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'data_agendamento',
                'label' => 'Data/Hora',
                'value' => function($model) {
                    return date('d/m/Y H:i', strtotime($model->data_agendamento));
                },
            ],
            [
                'attribute' => 'cliente_id',
                'label' => 'Cliente',
                'value' => 'cliente.nome',
            ],
            [
                'attribute' => 'servico_id',
                'label' => 'Serviço',
                'value' => 'servico.nome',
            ],
            [
                'attribute' => 'funcionario_id',
                'label' => 'Funcionário',
                'value' => 'funcionario.nome',
            ],
            [
                'attribute' => 'status',
                'label' => 'Status',
                'format' => 'html',
                'value' => function($model) {
                    $badgeClass = '';
                    switch($model->status) {
                        case Agendamento::STATUS_PENDENTE:
                            $badgeClass = 'bg-warning';
                            break;
                        case Agendamento::STATUS_CONFIRMADO:
                            $badgeClass = 'bg-success';
                            break;
                        case Agendamento::STATUS_CANCELADO:
                            $badgeClass = 'bg-danger';
                            break;
                        case Agendamento::STATUS_CONCLUIDO:
                            $badgeClass = 'bg-secondary';
                            break;
                    }
                    return '<span class="badge ' . $badgeClass . '">' . $model->getStatusLabel() . '</span>';
                }
            ],
            [
                'attribute' => 'observacoes',
                'label' => 'Observações',
                'value' => function($model) {
                    return $model->observacoes ? substr($model->observacoes, 0, 50) . '...' : '-';
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{confirm} {cancel}',
                'buttons' => [
                    'confirm' => function($url, $model) {
                        if ($model->status == Agendamento::STATUS_PENDENTE) {
                            return Html::a('Confirmar', ['confirmar-agendamento', 'id' => $model->id, 'view' => 'lista'], [
                                'class' => 'btn btn-sm btn-success',
                                'data-method' => 'post',
                            ]);
                        }
                        return '';
                    },
                    'cancel' => function($url, $model) {
                        if ($model->status != Agendamento::STATUS_CANCELADO) {
                            return Html::a('Cancelar', ['cancelar-agendamento', 'id' => $model->id, 'view' => 'lista'], [
                                'class' => 'btn btn-sm btn-danger',
                                'data-confirm' => 'Tem certeza?',
                                'data-method' => 'post',
                            ]);
                        }
                        return '';
                    },
                ],
            ],
        ],
    ]); ?>
    
<?php else: ?>
    <!-- Visualização em Calendário -->
    <div class="row">
        <div class="col-12">
            <?= $this->render('_calendario_gestao', [
                'agendamentosSemana' => $agendamentosSemana,
                'inicioSemana' => $inicioSemana,
                'fimSemana' => $fimSemana,
                'estatisticas' => $estatisticas,
            ]) ?>
        </div>
    </div>
<?php endif; ?>
