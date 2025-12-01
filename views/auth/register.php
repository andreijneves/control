<?php
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SignupForm */

$this->title = 'Cadastro da Barbearia';
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>Preencha os dados para criar sua conta.</p>
    <div class="row">
        <div class="col-lg-6">
            <?php $form = ActiveForm::begin(); ?>

            <h4>Barbearia</h4>
            <?= $form->field($model, 'barbershop_name') ?>
            <?= $form->field($model, 'barbershop_email') ?>

            <h4>Administrador</h4>
            <?= $form->field($model, 'username') ?>
            <?= $form->field($model, 'email') ?>
            <?= $form->field($model, 'password')->passwordInput() ?>

            <div class="form-group mt-3">
                <?= Html::submitButton('Cadastrar', ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
