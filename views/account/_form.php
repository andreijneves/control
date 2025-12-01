<?php
use yii\bootstrap5\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use app\models\Account;

/* @var $this yii\web\View */
/* @var $model app\models\Account */

$roles = [Account::ROLE_ADMIN => 'Administrador', Account::ROLE_STAFF => 'Atendente'];
?>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'username') ?>
<?= $form->field($model, 'email') ?>
<?= $form->field($model, 'password')->passwordInput() ?>
<?= $form->field($model, 'role')->dropDownList($roles) ?>

<div class="form-group mt-3">
    <?= Html::submitButton($model->isNewRecord ? 'Criar' : 'Salvar', ['class' => 'btn btn-primary']) ?>
    <?= Html::a('Cancelar', ['index'], ['class' => 'btn btn-secondary']) ?>
</div>

<?php ActiveForm::end(); ?>
