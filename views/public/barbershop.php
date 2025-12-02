<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $barbershop app\models\Barbershop */
/* @var $employees app\models\Employee[] */
/* @var $services app\models\Service[] */

$this->title = Html::encode($barbershop->name);
?>

<div class="barbershop-public">
    <div class="container py-5">
        <div class="row mb-4">
            <div class="col-md-8">
                <h1><?= Html::encode($barbershop->name) ?></h1>
                <p>
                    <?php if ($barbershop->address): ?>
                        <strong>Endereço:</strong> <?= Html::encode($barbershop->address) ?><br>
                    <?php endif; ?>
                    <?php if ($barbershop->phone): ?>
                        <strong>Telefone:</strong> <?= Html::encode($barbershop->phone) ?><br>
                    <?php endif; ?>
                    <?php if ($barbershop->email): ?>
                        <strong>E-mail:</strong> <?= Html::encode($barbershop->email) ?><br>
                    <?php endif; ?>
                </p>
            </div>
            <div class="col-md-4 text-end">
                <?= Html::a('Agendar Horário', ['book', 'id' => $barbershop->id], ['class' => 'btn btn-primary btn-lg']) ?>
            </div>
        </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-4">
                <h3>Serviços</h3>
                <?php if ($services): ?>
                    <div class="list-group">
                        <?php foreach ($services as $s): ?>
                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1"><?= Html::encode($s->name) ?></h5>
                                    <?php if ($s->price !== null): ?>
                                        <strong class="text-success">R$ <?= number_format((float)$s->price, 2, ',', '.') ?></strong>
                                    <?php endif; ?>
                                </div>
                                <?php if ($s->description): ?>
                                    <p class="mb-1"><?= nl2br(Html::encode($s->description)) ?></p>
                                <?php endif; ?>
                                <?php if ($s->duration_min): ?>
                                    <small class="text-muted">Duração: <?= (int)$s->duration_min ?> min</small>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-muted">Nenhum serviço cadastrado.</p>
                <?php endif; ?>
            </div>

            <div class="col-md-6 mb-4">
                <h3>Equipe</h3>
                <?php if ($employees): ?>
                    <div class="list-group">
                        <?php foreach ($employees as $e): ?>
                            <div class="list-group-item">
                                <h5 class="mb-1"><?= Html::encode($e->name) ?></h5>
                                <?php if ($e->phone): ?>
                                    <small class="text-muted">📞 <?= Html::encode($e->phone) ?></small><br>
                                <?php endif; ?>
                                <?php if ($e->email): ?>
                                    <small class="text-muted">✉️ <?= Html::encode($e->email) ?></small>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-muted">Nenhum funcionário cadastrado.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>