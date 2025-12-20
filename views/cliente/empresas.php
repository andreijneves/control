<?php

use yii\bootstrap5\Html;

$this->title = 'Empresas Disponíveis';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="empresas-lista">
    <div class="jumbotron bg-primary text-white text-center p-5 rounded mb-5">
        <h1 class="display-4">🏢 Empresas Disponíveis</h1>
        <p class="lead">Escolha uma empresa para ver seus serviços e fazer agendamentos</p>
    </div>

    <div class="row">
        <?php if (empty($empresas)): ?>
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle fa-2x mb-3"></i>
                    <h4>Nenhuma empresa cadastrada</h4>
                    <p>Ainda não há empresas disponíveis para agendamento.</p>
                    <?= Html::a('Cadastrar sua Empresa', ['/site/cadastro-empresa'], ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        <?php else: ?>
            <?php foreach ($empresas as $empresa): ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title text-primary">
                                <i class="fas fa-building"></i> 
                                <?= Html::encode($empresa->nome) ?>
                            </h5>
                            
                            <?php if ($empresa->descricao): ?>
                                <p class="card-text text-muted">
                                    <?= Html::encode(substr($empresa->descricao, 0, 100)) ?>
                                    <?= strlen($empresa->descricao) > 100 ? '...' : '' ?>
                                </p>
                            <?php endif; ?>
                            
                            <div class="text-muted small mb-3">
                                <?php if ($empresa->cidade): ?>
                                    <p class="mb-1">
                                        <i class="fas fa-map-marker-alt"></i> 
                                        <?= Html::encode($empresa->cidade) ?>
                                    </p>
                                <?php endif; ?>
                                
                                <?php if ($empresa->telefone): ?>
                                    <p class="mb-1">
                                        <i class="fas fa-phone"></i> 
                                        <?= Html::encode($empresa->telefone) ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="card-footer bg-transparent">
                            <?= Html::a(
                                '<i class="fas fa-calendar-alt"></i> Acessar e Agendar', 
                                ['/cliente/area-publica', 'empresa_id' => $empresa->id], 
                                ['class' => 'btn btn-success btn-block w-100']
                            ) ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>