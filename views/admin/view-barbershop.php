<?php
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $barbershop app\models\Barbershop */
/* @var $accountsProvider yii\data\ActiveDataProvider */

$this->title = $barbershop->name;
?>
<div class="admin-view-barbershop">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Editar', ['update-barbershop', 'id' => $barbershop->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Excluir', ['delete-barbershop', 'id' => $barbershop->id], [
            'class' => 'btn btn-danger',
            'data-confirm' => 'Tem certeza que deseja excluir esta barbearia?',
            'data-method' => 'post',
        ]) ?>
        <?= Html::a('Ver Página Pública', ['/public/barbershop', 'id' => $barbershop->id], ['class' => 'btn btn-info', 'target' => '_blank']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $barbershop,
        'attributes' => [
            'id',
            'name',
            'email:email',
            'phone',
            'address',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

    <h3 class="mt-4">Usuários da Barbearia</h3>
    <?= GridView::widget([
        'dataProvider' => $accountsProvider,
        'columns' => [
            'id',
            'username',
            'email:email',
            'role',
            [
                'attribute' => 'status',
                'value' => function($model) {
                    return $model->status == 10 ? 'Ativo' : 'Inativo';
                }
            ],
            'created_at:datetime',
        ],
    ]) ?>
</div>
