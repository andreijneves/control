<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use app\models\Horario;

$this->title = 'Configurar Horários - ' . $funcionario->nome;
$this->params['breadcrumbs'][] = ['label' => 'Funcionários', 'url' => ['funcionarios']];
$this->params['breadcrumbs'][] = $this->title;

$diasSemana = Horario::diasSemana();
$horariosArray = [];
foreach ($horarios as $horario) {
    $horariosArray[$horario->dia_semana] = $horario;
}
?>

<h1><?= Html::encode($this->title) ?></h1>

<?php $form = ActiveForm::begin(['method' => 'post']); ?>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Dia da Semana</th>
                    <th>Hora Início</th>
                    <th>Hora Fim</th>
                    <th>Disponível</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($diasSemana as $dia => $label): ?>
                    <tr>
                        <td><?= $label ?></td>
                        <td>
                            <input type="time" name="horarios[<?= $dia ?>][hora_inicio]" class="form-control" 
                                   value="<?= isset($horariosArray[$dia]) ? $horariosArray[$dia]->hora_inicio : '' ?>">
                        </td>
                        <td>
                            <input type="time" name="horarios[<?= $dia ?>][hora_fim]" class="form-control"
                                   value="<?= isset($horariosArray[$dia]) ? $horariosArray[$dia]->hora_fim : '' ?>">
                        </td>
                        <td>
                            <input type="checkbox" name="horarios[<?= $dia ?>][disponivel]" value="1"
                                   <?= isset($horariosArray[$dia]) && $horariosArray[$dia]->disponivel ? 'checked' : '' ?>>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Salvar Horários', ['class' => 'btn btn-success']) ?>
        <?= Html::a('Cancelar', ['funcionarios'], ['class' => 'btn btn-secondary ms-2']) ?>
    </div>

<?php ActiveForm::end(); ?>
