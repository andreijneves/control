<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Servico;
use app\models\Funcionario;

$this->title = 'Agendar Serviço';
$this->params['breadcrumbs'][] = $this->title;

// Buscar funcionários da empresa
$funcionarios = Funcionario::find()->where(['empresa_id' => $cliente->empresa_id])->all();
$funcionariosArray = ArrayHelper::map($funcionarios, 'id', 'nome');
$servicosArray = ArrayHelper::map($servicos, 'id', 'nome');
?>

<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0">Agendar Serviço</h3>
            </div>
            <div class="card-body">
                <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'servico_id')->dropDownList($servicosArray, ['prompt' => 'Selecione um serviço']) ?>

                    <?= $form->field($model, 'funcionario_id')->dropDownList($funcionariosArray, ['prompt' => 'Selecione um funcionário']) ?>

                    <?= $form->field($model, 'data_agendamento')->textInput(['type' => 'datetime-local']) ?>

                    <?= $form->field($model, 'observacoes')->textarea(['rows' => 3]) ?>

                    <div class="form-group">
                        <?= Html::submitButton('Agendar', ['class' => 'btn btn-success']) ?>
                        <?= Html::a('Cancelar', ['/cliente/index'], ['class' => 'btn btn-secondary ms-2']) ?>
                    </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
