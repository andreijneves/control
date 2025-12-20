<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\Card;

$this->title = 'Configurar Horários dos Funcionários';
$this->params['breadcrumbs'][] = ['label' => 'Dashboard', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Configurações', 'url' => ['configuracoes']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="listar-funcionarios-horarios">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-info" role="alert">
        <i class="fas fa-info-circle"></i>
        Selecione um funcionário para configurar seus horários de disponibilidade.
    </div>

    <?php if (empty($funcionarios)): ?>
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle"></i>
            Nenhum funcionário cadastrado. 
            <?= Html::a('Cadastrar funcionário', ['criar-funcionario'], ['class' => 'alert-link']) ?>
        </div>
    <?php else: ?>
        <div class="row">
            <?php foreach ($funcionarios as $funcionario): ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">
                                <i class="fas fa-user-tie"></i>
                                <?= Html::encode($funcionario->nome) ?>
                            </h5>
                            
                            <div class="mb-3">
                                <p class="card-text">
                                    <strong>CPF:</strong> <?= Html::encode($funcionario->cpf ?: 'N/A') ?><br>
                                    <strong>Cargo:</strong> <?= Html::encode($funcionario->cargo ?: 'N/A') ?><br>
                                    <strong>Email:</strong> <?= Html::encode($funcionario->email ?: 'N/A') ?><br>
                                    <strong>Telefone:</strong> <?= Html::encode($funcionario->telefone ?: 'N/A') ?>
                                </p>
                            </div>

                            <div class="d-grid gap-2">
                                <?= Html::a(
                                    '🕐 Configurar Horários',
                                    ['configurar-horarios', 'funcionario_id' => $funcionario->id],
                                    ['class' => 'btn btn-primary']
                                ) ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- Link de voltar -->
    <div class="mt-4">
        <?= Html::a('← Voltar para Configurações', ['configuracoes'], ['class' => 'btn btn-secondary']) ?>
    </div>
</div>
