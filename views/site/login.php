<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use app\models\LoginForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row justify-content-center mt-5">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0">Login</h3>
            </div>
            <div class="card-body">
                <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                    <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                    <?= $form->field($model, 'password')->passwordInput() ?>

                    <?= $form->field($model, 'rememberMe')->checkbox() ?>

                    <div class="form-group">
                        <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                    </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>

        <div class="mt-3 text-center">
            <p><?= Html::a('Não tem uma conta? Cadastre sua empresa!', ['/site/cadastro-empresa']) ?></p>
        </div>
    </div>
</div>
