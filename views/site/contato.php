<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use app\models\ContactForm;

$this->title = 'Contato';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row justify-content-center mt-5">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0">Fale Conosco</h3>
            </div>
            <div class="card-body">
                <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

                    <?= $form->field($model, 'nome') ?>
                    <?= $form->field($model, 'email') ?>
                    <?= $form->field($model, 'assunto') ?>
                    <?= $form->field($model, 'mensagem')->textarea(['rows' => 5]) ?>

                    <div class="form-group">
                        <?= Html::submitButton('Enviar', ['class' => 'btn btn-primary']) ?>
                    </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
