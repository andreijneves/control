<?php

use yii\bootstrap5\Html;

$this->title = 'Nossas Empresas';
?>

<div class="lista-empresas">
    <div class="page-header text-center mb-5">
        <h1><?= Html::encode($this->title) ?></h1>
        <p class="lead text-muted">Conheça os serviços disponíveis</p>
    </div>

    <?php if (empty($empresas)): ?>
        <div class="alert alert-info text-center">
            <i class="fas fa-info-circle"></i>
            Nenhuma empresa disponível no momento.
        </div>
    <?php else: ?>
        <div class="row">
            <?php foreach ($empresas as $empresa): ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm hover-shadow">
                        <div class="card-body">
                            <h5 class="card-title">
                                <i class="fas fa-building"></i>
                                <?= Html::encode($empresa->nome) ?>
                            </h5>

                            <?php if ($empresa->descricao): ?>
                                <p class="card-text text-muted small">
                                    <?= Html::encode(substr($empresa->descricao, 0, 100)) ?>
                                    <?php if (strlen($empresa->descricao) > 100): ?>...<?php endif; ?>
                                </p>
                            <?php endif; ?>

                            <div class="mt-3 small">
                                <?php if ($empresa->telefone): ?>
                                    <p class="mb-1">
                                        <i class="fas fa-phone"></i> 
                                        <?= Html::encode($empresa->telefone) ?>
                                    </p>
                                <?php endif; ?>
                                <?php if ($empresa->email): ?>
                                    <p class="mb-1">
                                        <i class="fas fa-envelope"></i> 
                                        <?= Html::encode($empresa->email) ?>
                                    </p>
                                <?php endif; ?>
                                <?php if ($empresa->endereco): ?>
                                    <p class="mb-0">
                                        <i class="fas fa-map-marker-alt"></i> 
                                        <?= Html::encode(substr($empresa->endereco, 0, 50)) ?>
                                        <?php if (strlen($empresa->endereco) > 50): ?>...<?php endif; ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-top">
                            <?= Html::a(
                                '👁️ Ver Detalhes',
                                ['area-publica', 'empresa_id' => $empresa->id],
                                ['class' => 'btn btn-primary btn-sm w-100']
                            ) ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<style>
.hover-shadow {
    transition: box-shadow 0.3s ease-in-out;
}

.hover-shadow:hover {
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}
</style>
