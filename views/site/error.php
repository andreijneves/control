<?php

use yii\bootstrap5\Html;

$this->title = 'Erro - ' . $code;
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="alert alert-danger" role="alert">
                <h1 class="alert-heading">
                    <i class="fas fa-exclamation-triangle"></i>
                    Erro <?= Html::encode($code) ?>
                </h1>
                <hr>
                <p class="mb-0">
                    <strong><?= Html::encode($name) ?></strong>
                </p>
                <p class="mt-2">
                    <?= Html::encode($message) ?>
                </p>
            </div>

            <div class="card mt-4">
                <div class="card-body">
                    <p>Ocorreu um erro ao processar sua solicitação.</p>
                    
                    <?php if (!YII_ENV_PROD): ?>
                        <hr>
                        <p><strong>Detalhes do Erro (apenas em desenvolvimento):</strong></p>
                        <pre class="bg-light p-3 rounded"><code><?= Html::encode($exception->__toString()) ?></code></pre>
                    <?php endif; ?>

                    <div class="mt-4">
                        <?= Html::a('Voltar para a Página Inicial', ['/site/index'], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('Fazer Login', ['/site/login'], ['class' => 'btn btn-secondary ms-2']) ?>
                    </div>
                </div>
            </div>

            <div class="mt-4 p-3 bg-light rounded">
                <p class="text-muted small">
                    Se o problema persistir, entre em contato com o suporte.
                </p>
            </div>
        </div>
    </div>
</div>
