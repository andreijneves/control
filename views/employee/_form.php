<?php
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Employee */

?>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'name') ?>
<?= $form->field($model, 'email') ?>
<?= $form->field($model, 'phone') ?>

<div class="form-group mt-3">
    <?= Html::submitButton($model->isNewRecord ? 'Criar' : 'Salvar', ['class' => 'btn btn-primary']) ?>
    <?= Html::a('Cancelar', ['index'], ['class' => 'btn btn-secondary']) ?>
    
</div>

<?php ActiveForm::end(); ?>
