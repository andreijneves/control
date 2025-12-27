<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Cadastro como Cliente';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row justify-content-center mt-5">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0">Complete seu Cadastro</h3>
            </div>
            <div class="card-body">
                <p class="text-muted">Preencha os dados abaixo para se cadastrar como cliente nesta empresa.</p>

                <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'nome') ?>
                    <?= $form->field($model, 'cpf') ?>
                    <?= $form->field($model, 'email') ?>
                    <?= $form->field($model, 'telefone') ?>
                    <?= $form->field($model, 'endereco')->textarea(['rows' => 3]) ?>

                    <div class="form-group">
                        <?= Html::submitButton('Cadastrar', ['class' => 'btn btn-success']) ?>
                        <?= Html::a('Cancelar', ['/site/index'], ['class' => 'btn btn-secondary ms-2']) ?>
                    </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
