<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Horários de Funcionamento da Empresa';
$this->params['breadcrumbs'][] = ['label' => 'Dashboard', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Configurações', 'url' => ['configuracoes']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="horario-empresa">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-info">
        <i class="fas fa-info-circle"></i>
        Configure os horários de funcionamento da sua empresa. Estes horários serão exibidos na área pública.
    </div>

    <div class="card">
        <div class="card-body">
            <?php $form = ActiveForm::begin(['id' => 'form-horarios']); ?>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Dia da Semana</th>
                            <th>Hora Início <span class="text-muted">(opcional)</span></th>
                            <th>Hora Fim <span class="text-muted">(opcional)</span></th>
                            <th class="text-center">Aberto</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $diasSemana = [
                            0 => 'Domingo',
                            1 => 'Segunda-feira',
                            2 => 'Terça-feira',
                            3 => 'Quarta-feira',
                            4 => 'Quinta-feira',
                            5 => 'Sexta-feira',
                            6 => 'Sábado',
                        ];

                        // Mapear horários existentes
                        $horarioPorDia = [];
                        foreach ($horarios as $horario) {
                            $horarioPorDia[$horario->dia_semana] = $horario;
                        }

                        foreach ($diasSemana as $dia => $nomeDia):
                            $horario = $horarioPorDia[$dia] ?? null;
                        ?>
                            <tr>
                                <td>
                                    <strong><?= $nomeDia ?></strong>
                                </td>
                                <td>
                                    <input type="time" 
                                           name="horarios[<?= $dia ?>][hora_inicio]" 
                                           class="form-control" 
                                           value="<?= $horario ? substr($horario->hora_inicio, 0, 5) : '' ?>">
                                </td>
                                <td>
                                    <input type="time" 
                                           name="horarios[<?= $dia ?>][hora_fim]" 
                                           class="form-control" 
                                           value="<?= $horario ? substr($horario->hora_fim, 0, 5) : '' ?>">
                                </td>
                                <td class="text-center">
                                    <div class="form-check d-inline-block">
                                        <input type="checkbox" 
                                               name="horarios[<?= $dia ?>][disponivel]" 
                                               class="form-check-input" 
                                               id="disponivel_<?= $dia ?>"
                                               value="1"
                                               <?= $horario && $horario->disponivel ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="disponivel_<?= $dia ?>">
                                            Sim
                                        </label>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="alert alert-warning mt-3">
                <small>
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Dica:</strong> Deixe os campos de hora vazios para dias em que a empresa está fechada. 
                    Marque "Aberto" apenas quando a empresa funciona naquele dia.
                </small>
            </div>

            <div class="form-group mt-4">
                <?= Html::submitButton('💾 Salvar Horários', ['class' => 'btn btn-primary btn-lg']) ?>
                <?= Html::a('Voltar', ['configuracoes'], ['class' => 'btn btn-secondary btn-lg ms-2']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
