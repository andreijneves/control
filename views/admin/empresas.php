<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\Alert;
use yii\grid\GridView;

$this->title = 'Empresas';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<?php if (Yii::$app->session->hasFlash('success')): ?>
    <?= Alert::widget([
        'body' => Yii::$app->session->getFlash('success'),
        'options' => ['class' => 'alert-success']
    ]) ?>
<?php endif; ?>

<?php if (Yii::$app->session->hasFlash('error')): ?>
    <?= Alert::widget([
        'body' => Yii::$app->session->getFlash('error'),
        'options' => ['class' => 'alert-danger']
    ]) ?>
<?php endif; ?>

<p>
    <?= Html::a('Criar Empresa', ['criar-empresa'], ['class' => 'btn btn-success']) ?>
</p>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        'id',
        'nome',
        'cnpj',
        'email:email',
        'telefone',
        [
            'attribute' => 'status',
            'value' => function($model) {
                return $model->status == 1 ? 'Ativo' : 'Inativo';
            }
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update} {delete}',
            'buttons' => [
                'update' => function($url, $model) {
                    return Html::a('Editar', ['editar-empresa', 'id' => $model->id], ['class' => 'btn btn-sm btn-primary']);
                },
                'delete' => function($url, $model) {
                    return Html::beginForm(['deletar-empresa', 'id' => $model->id], 'post', [
                        'style' => 'display:inline-block;',
                        'onsubmit' => "return confirm('⚠️ ATENÇÃO: Deletar a empresa \'{$model->nome}\' irá remover PERMANENTEMENTE:\\n\\n• Todos os usuários da empresa\\n• Todos os clientes\\n• Todos os funcionários\\n• Todos os serviços\\n• Todos os agendamentos\\n• Todos os horários\\n\\nEsta ação NÃO PODE ser desfeita!\\n\\nTem certeza que deseja continuar?');"
                    ]) . 
                    Html::submitButton('Deletar', [
                        'class' => 'btn btn-sm btn-danger',
                    ]) . 
                    Html::endForm();
                },
            ],
        ],
    ],
]); ?>
