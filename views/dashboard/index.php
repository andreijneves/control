<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $barbershop app\models\Barbershop|null */
/* @var $employeesCount int */
/* @var $servicesCount int */
/* @var $usersCount int */
/* @var $recentEmployees app\models\Employee[] */
/* @var $recentServices app\models\Service[] */

$this->title = 'Dashboard';
?>
<div class="dashboard-index">
    <h1><?= Html::encode($this->title) ?><?= $barbershop ? ' — ' . Html::encode($barbershop->name) : '' ?></h1>

    <div class="row mt-3">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Funcionários</h5>
                    <p class="card-text display-6 mb-0"><?= (int)$employeesCount ?></p>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <?= Html::a('Gerenciar', ['employee/index'], ['class' => 'btn btn-light btn-sm']) ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Serviços</h5>
                    <p class="card-text display-6 mb-0"><?= (int)$servicesCount ?></p>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <?= Html::a('Gerenciar', ['service/index'], ['class' => 'btn btn-light btn-sm']) ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-dark mb-3">
                <div class="card-body">
                    <h5 class="card-title">Usuários</h5>
                    <p class="card-text display-6 mb-0"><?= (int)$usersCount ?></p>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <?= Html::a('Gerenciar', ['account/index'], ['class' => 'btn btn-light btn-sm']) ?>
                </div>
            </div>
        </div>
    </div>

        <div class="row mt-2">
            <div class="col-md-6">
                <h4>Funcionários Recentes</h4>
                <?php if (!empty($recentEmployees)): ?>
                    <ul class="list-group">
                        <?php foreach ($recentEmployees as $e): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>
                                    <?= Html::encode($e->name) ?>
                                    <?php if ($e->email): ?>
                                        <small class="text-muted">— <?= Html::encode($e->email) ?></small>
                                    <?php endif; ?>
                                </span>
                                <small class="text-muted"><?= Yii::$app->formatter->asDatetime($e->created_at) ?></small>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="text-muted">Nenhum funcionário cadastrado ainda.</p>
                <?php endif; ?>
            </div>
            <div class="col-md-6">
                <h4>Serviços Recentes</h4>
                <?php if (!empty($recentServices)): ?>
                    <ul class="list-group">
                        <?php foreach ($recentServices as $s): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>
                                    <?= Html::encode($s->name) ?>
                                    <small class="text-muted">
                                        — <?= Yii::$app->formatter->asDecimal((float)$s->price, 2) ?>
                                        <?php if ($s->duration_min): ?> · <?= (int)$s->duration_min ?> min<?php endif; ?>
                                    </small>
                                </span>
                                <small class="text-muted"><?= Yii::$app->formatter->asDatetime($s->created_at) ?></small>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="text-muted">Nenhum serviço cadastrado ainda.</p>
                <?php endif; ?>
            </div>
        </div>

        <p class="mt-3">Atalhos:</p>
    <ul>
        <li><?= Html::a('Funcionários', ['employee/index']) ?></li>
        <li><?= Html::a('Serviços', ['service/index']) ?></li>
        <li><?= Html::a('Usuários', ['account/index']) ?></li>
        <li>
            <?php if ($barbershop): ?>
                <?php if (!empty($barbershop->slug)): ?>
                    <?= Html::a('Ver página pública da barbearia', ['public/barbershop', 'slug' => $barbershop->slug], ['target' => '_blank']) ?>
                <?php else: ?>
                    <?= Html::a('Ver página pública da barbearia', ['public/barbershop', 'id' => $barbershop->id], ['target' => '_blank']) ?>
                <?php endif; ?>
            <?php endif; ?>
        </li>
    </ul>
</div>
