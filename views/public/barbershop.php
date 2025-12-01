<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $barbershop app\models\Barbershop */
/* @var $employees app\models\Employee[] */
/* @var $services app\models\Service[] */

$this->title = Html::encode($barbershop->name);
?>

<div class="barbershop-public">
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

    <h3>Serviços</h3>
    <?php if ($services): ?>
        <ul>
            <?php foreach ($services as $s): ?>
                <li>
                    <strong><?= Html::encode($s->name) ?></strong>
                    <?php if ($s->price !== null): ?> - R$ <?= number_format((float)$s->price, 2, ',', '.') ?><?php endif; ?>
                    <?php if ($s->duration_min): ?> (<?= (int)$s->duration_min ?> min)<?php endif; ?><br>
                    <?php if ($s->description): ?>
                        <small><?= nl2br(Html::encode($s->description)) ?></small>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p class="text-muted">Nenhum serviço cadastrado.</p>
    <?php endif; ?>

    <h3>Equipe</h3>
    <?php if ($employees): ?>
        <ul>
            <?php foreach ($employees as $e): ?>
                <li>
                    <?= Html::encode($e->name) ?>
                    <?php if ($e->phone): ?> - <?= Html::encode($e->phone) ?><?php endif; ?>
                    <?php if ($e->email): ?> - <?= Html::encode($e->email) ?><?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p class="text-muted">Nenhum funcionário cadastrado.</p>
    <?php endif; ?>
</div>
