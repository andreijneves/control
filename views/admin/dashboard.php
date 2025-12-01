<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $barbershopsCount int */
/* @var $accountsCount int */
/* @var $recentBarbershops app\models\Barbershop[] */

$this->title = 'Dashboard Admin';
?>
<div class="admin-dashboard">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Barbearias</h5>
                    <p class="card-text display-4"><?= $barbershopsCount ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Usuários</h5>
                    <p class="card-text display-4"><?= $accountsCount ?></p>
                </div>
            </div>
        </div>
    </div>

    <h3 class="mt-4">Barbearias Recentes</h3>
    <?php if ($recentBarbershops): ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Criado em</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recentBarbershops as $b): ?>
                    <tr>
                        <td><?= $b->id ?></td>
                        <td><?= Html::encode($b->name) ?></td>
                        <td><?= Html::encode($b->email) ?></td>
                        <td><?= Yii::$app->formatter->asDatetime($b->created_at) ?></td>
                        <td>
                            <?= Html::a('Ver', ['/admin/view-barbershop', 'id' => $b->id], ['class' => 'btn btn-sm btn-info']) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="text-muted">Nenhuma barbearia cadastrada ainda.</p>
    <?php endif; ?>
</div>
