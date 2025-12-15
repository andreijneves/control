<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'Sistema de Controle';

$this->registerCss("
.hero-section {
    text-align: center;
    padding: 3rem 0;
    margin-bottom: 3rem;
}

.hero-section h1 {
    font-size: 3rem;
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 1rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.hero-section p {
    font-size: 1.3rem;
    color: #4a5568;
    margin-bottom: 2rem;
}

.feature-card {
    padding: 2rem;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
    border-radius: 12px;
    border: 2px solid rgba(102, 126, 234, 0.1);
    transition: all 0.3s ease;
    height: 100%;
}

.feature-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.2);
    border-color: rgba(102, 126, 234, 0.3);
}

.feature-card h3 {
    color: #667eea;
    font-weight: 600;
    margin-bottom: 1rem;
}

.feature-card p {
    color: #4a5568;
    line-height: 1.6;
}

.feature-icon {
    font-size: 3rem;
    margin-bottom: 1rem;
}
");
?>
<div class="site-index">

    <div class="hero-section">
        <h1>Gestão Inteligente</h1>
        <p>Simplifique a administração de organizações, serviços e equipes</p>
    </div>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="feature-card">
                <div class="feature-icon">🏢</div>
                <h3>Organizações</h3>
                <p>Gerencie múltiplas organizações com informações completas, CNPJ, contatos e endereços em um único lugar.</p>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="feature-card">
                <div class="feature-icon">⚙️</div>
                <h3>Serviços</h3>
                <p>Cadastre serviços com preços, duração e descrições detalhadas. Controle completo do portfólio de cada organização.</p>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="feature-card">
                <div class="feature-icon">👥</div>
                <h3>Funcionários</h3>
                <p>Cadastro automático de usuários para funcionários com controle de cargos, permissões e acessos individualizados.</p>
            </div>
        </div>
    </div>

</div>
