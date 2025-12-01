<?php
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AdminLoginForm */

$this->title = 'Login Admin';
?>
<div class="admin-login">
    <div class="row justify-content-center" style="margin-top: 100px;">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h4 class="mb-0"><?= Html::encode($this->title) ?></h4>
                </div>
                <div class="card-body">
                    <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
                    <?= $form->field($model, 'password')->passwordInput() ?>
                    <?= $form->field($model, 'rememberMe')->checkbox() ?>

                    <div class="form-group mt-3">
                        <?= Html::submitButton('Entrar', ['class' => 'btn btn-danger w-100']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
