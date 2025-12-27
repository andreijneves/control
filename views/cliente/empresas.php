<?php

use yii\bootstrap5\Html;

$this->title = 'Escolha uma Empresa';
?>

<div class="empresas-publicas">
    <div class="hero-section text-center mb-5">
        <h1 class="display-4 mb-3">🏢 Encontre os Melhores Serviços</h1>
        <p class="lead text-muted">Escolha uma empresa e agende seus serviços de forma rápida e fácil</p>
        
        <div class="alert alert-info d-inline-block mt-3">
            <i class="fas fa-info-circle"></i>
            <strong>Como funciona:</strong> Escolha uma empresa → Cadastre-se ou faça login → Agende seus serviços online
        </div>
    </div>

    <?php if (empty($empresas)): ?>
        <div class="empty-state text-center py-5">
            <div class="mb-4">
                <i class="fas fa-store fa-4x text-muted"></i>
            </div>
            <h3 class="text-muted">Nenhuma empresa disponível</h3>
            <p class="text-muted">Não há empresas cadastradas no momento.</p>
        </div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach ($empresas as $empresa): ?>
                <div class="col-lg-4 col-md-6">
                    <div class="empresa-card">
                        <div class="empresa-header">
                            <h3 class="empresa-nome">
                                <?= Html::encode($empresa->nome) ?>
                            </h3>
                        </div>
                        
                        <div class="empresa-body">
                            <?php if ($empresa->descricao): ?>
                                <p class="empresa-desc">
                                    <?= Html::encode(substr($empresa->descricao, 0, 120)) ?>
                                    <?= strlen($empresa->descricao) > 120 ? '...' : '' ?>
                                </p>
                            <?php endif; ?>
                            
                            <div class="empresa-info">
                                <?php if ($empresa->cidade): ?>
                                    <div class="info-item">
                                        <span class="info-icon">📍</span>
                                        <?= Html::encode($empresa->cidade) ?>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if ($empresa->telefone): ?>
                                    <div class="info-item">
                                        <span class="info-icon">📞</span>
                                        <?= Html::encode($empresa->telefone) ?>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if ($empresa->email): ?>
                                    <div class="info-item">
                                        <span class="info-icon">✉️</span>
                                        <?= Html::encode($empresa->email) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="empresa-footer">
                            <?= Html::a('Ver Serviços e Agendar', ['/cliente/area-publica', 'empresa_id' => $empresa->id], [
                                'class' => 'btn btn-agendar'
                            ]) ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<style>
.empresas-publicas {
    max-width: 1200px;
    margin: 0 auto;
}

.hero-section h1 {
    color: #2d3748;
    font-weight: 700;
}

.empresa-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    border: 1px solid #e2e8f0;
    transition: all 0.3s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.empresa-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0,0,0,0.15);
}

.empresa-header {
    padding: 2rem 2rem 1rem 2rem;
    background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%);
    color: white;
    border-radius: 15px 15px 0 0;
}

.empresa-nome {
    font-size: 1.4rem;
    font-weight: 600;
    margin: 0;
    text-align: center;
}

.empresa-body {
    padding: 1.5rem 2rem;
    flex-grow: 1;
}

.empresa-desc {
    color: #4a5568;
    line-height: 1.6;
    margin-bottom: 1.5rem;
}

.empresa-info {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.info-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    color: #718096;
    font-size: 0.95rem;
}

.info-icon {
    font-size: 1.1rem;
    width: 20px;
    text-align: center;
}

.empresa-footer {
    padding: 1.5rem 2rem 2rem 2rem;
    border-top: 1px solid #e2e8f0;
}

.btn-agendar {
    background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%);
    color: white;
    border: none;
    padding: 0.8rem 2rem;
    border-radius: 25px;
    font-weight: 600;
    width: 100%;
    transition: all 0.3s ease;
    text-align: center;
    text-decoration: none;
    display: block;
}

.btn-agendar:hover {
    background: linear-gradient(135deg, #3182ce 0%, #2c5aa0 100%);
    color: white;
    transform: translateY(-2px);
    text-decoration: none;
}

.empty-state {
    background: #f7fafc;
    border-radius: 15px;
    padding: 3rem;
    border: 2px dashed #cbd5e0;
}

@media (max-width: 768px) {
    .hero-section h1 {
        font-size: 2rem;
    }
    
    .empresa-header {
        padding: 1.5rem;
    }
    
    .empresa-body {
        padding: 1rem 1.5rem;
    }
    
    .empresa-footer {
        padding: 1rem 1.5rem 1.5rem 1.5rem;
    }
}
</style>