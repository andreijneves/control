<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use app\models\Profile;

/* @var $this yii\web\View */
/* @var $model app\models\SignupForm */
/* @var $form yii\bootstrap5\ActiveForm */

$this->title = 'Cadastrar Usuário';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Por favor, preencha os campos abaixo para se cadastrar:</p>

    <div class="row">
        <div class="col-lg-6">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'email')->input('email') ?>

                <?= $form->field($model, 'name')->textInput() ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= $form->field($model, 'password_repeat')->passwordInput() ?>

                <?= $form->field($model, 'role')->dropDownList(Profile::getRolesList(), ['prompt' => 'Selecione um perfil']) ?>

                <div class="form-group">
                    <?= Html::submitButton('Cadastrar', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
