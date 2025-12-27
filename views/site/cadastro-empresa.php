<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use app\models\Empresa;

$this->title = 'Cadastrar Empresa';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0">Cadastro de Empresa</h3>
            </div>
            <div class="card-body">
                <?php $form = ActiveForm::begin(['id' => 'cadastro-form']); ?>

                    <?= $form->field($model, 'nome') ?>
                    <?= $form->field($model, 'cnpj') ?>
                    <?= $form->field($model, 'email') ?>
                    <?= $form->field($model, 'telefone') ?>
                    <?= $form->field($model, 'endereco')->textarea(['rows' => 3]) ?>
                    
                    <div class="form-group">
                        <label class="form-label">Responsável pela Empresa</label>
                        <?= Html::textInput('responsavel', '', ['class' => 'form-control', 'placeholder' => 'Nome do responsável']) ?>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Senha de Acesso</label>
                        <?= Html::passwordInput('senha', '', ['class' => 'form-control', 'placeholder' => 'Defina uma senha']) ?>
                    </div>

                    <div class="form-group">
                        <?= Html::submitButton('Cadastrar', ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('Cancelar', ['/site/index'], ['class' => 'btn btn-secondary ms-2']) ?>
                    </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
