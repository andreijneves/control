<?php
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Service */

?>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'name') ?>
<?= $form->field($model, 'description')->textarea(['rows' => 4]) ?>
<?= $form->field($model, 'duration_min')->input('number', ['min' => 5, 'step' => 5]) ?>
<?= $form->field($model, 'price')->input('number', ['min' => 0, 'step' => '0.01']) ?>

<div class="form-group mt-3">
    <?= Html::submitButton($model->isNewRecord ? 'Criar' : 'Salvar', ['class' => 'btn btn-primary']) ?>
    <?= Html::a('Cancelar', ['index'], ['class' => 'btn btn-secondary']) ?>
</div>

<?php ActiveForm::end(); ?>
