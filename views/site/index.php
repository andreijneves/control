<?php

use yii\bootstrap5\Html;

$this->title = 'Control - Gestão de Serviços';
?>

<!-- Hero Section -->
<div class="hero-section">
    <div class="container">
        <div class="hero-content">
            <h1 class="display-4">🚀 Bem-vindo ao Control</h1>
            <p class="lead">Sistema inteligente de agendamento de serviços</p>
            <p class="description">
                <strong>Revolucione sua empresa!</strong> Automatize agendamentos, reduza cancelamentos e 
                aumente a satisfação dos seus clientes. Ganhe mais tempo para focar no que realmente importa: 
                fazer seu negócio crescer com tecnologia de ponta.
            </p>
            
            <div class="mt-4">
                <?= Html::a('<span>🏢 Cadastrar Empresa</span>', ['/site/cadastro-empresa'], [
                    'class' => 'btn btn-primary-modern btn-modern me-3 animate-pulse'
                ]) ?>
                <?= Html::a('<span>📋 Saiba Mais</span>', ['/site/sobre'], [
                    'class' => 'btn btn-outline-modern btn-modern'
                ]) ?>
            </div>
        </div>
    </div>
</div>

<!-- Estatísticas -->
<div class="stats-section">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-6">
                <div class="stat-card">
                    <span class="stat-number">24/7</span>
                    <span class="stat-label">Disponível</span>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-card">
                    <span class="stat-number">∞</span>
                    <span class="stat-label">Agendamentos</span>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-card">
                    <span class="stat-number">🔒</span>
                    <span class="stat-label">Seguro</span>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-card">
                    <span class="stat-number">⚡</span>
                    <span class="stat-label">Rápido</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Features Section -->
<div class="container my-5">
    <div class="text-center mb-5">
        <h2 class="display-5 fw-bold text-white">✨ Recursos Poderosos</h2>
        <p class="lead text-white opacity-75">Tudo o que você precisa para gerenciar sua empresa</p>
    </div>
    
    <div class="row">
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="feature-card">
                <div class="feature-icon">🛠️</div>
                <h5 class="card-title">Gerencie Serviços</h5>
                <p class="card-text">
                    Cadastre e organize todos os serviços da sua empresa com descrições detalhadas, 
                    preços e durações personalizadas.
                </p>
            </div>
        </div>
        
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="feature-card">
                <div class="feature-icon">👥</div>
                <h5 class="card-title">Controle de Funcionários</h5>
                <p class="card-text">
                    Gerencie funcionários e configure horários disponíveis, especialidades 
                    e vincule aos serviços específicos.
                </p>
            </div>
        </div>
        
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="feature-card">
                <div class="feature-icon">📅</div>
                <h5 class="card-title">Agendamentos Inteligentes</h5>
                <p class="card-text">
                    Sistema avançado que evita conflitos, permite cancelamentos online 
                    e envia notificações automáticas.
                </p>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-4">
            <div class="feature-card">
                <div class="feature-icon">📊</div>
                <h5 class="card-title">Dashboard Completo</h5>
                <p class="card-text">
                    Acompanhe métricas em tempo real, receita, agendamentos 
                    e performance da sua empresa em gráficos intuitivos.
                </p>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-4">
            <div class="feature-card">
                <div class="feature-icon">💬</div>
                <h5 class="card-title">Comunicação Automatizada</h5>
                <p class="card-text">
                    Lembretes automáticos por email/SMS, confirmações de agendamento 
                    e comunicação direta com clientes.
                </p>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-4">
            <div class="feature-card">
                <div class="feature-icon">🌐</div>
                <h5 class="card-title">Área Pública Personalizada</h5>
                <p class="card-text">
                    Cada empresa tem sua própria página de agendamentos com 
                    design personalizado e domínio exclusivo.
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Call to Action Section -->
<div class="container my-5">
    <div class="text-center">
        <h3 class="text-white mb-4">🎯 Pronto para Revolucionar seu Negócio?</h3>
        <p class="text-white opacity-75 mb-4">
            Junte-se a centenas de empresas que já transformaram sua operação com o Control
        </p>
        <?= Html::a('<span>🚀 Começar Agora - É Grátis!</span>', ['/site/cadastro-empresa'], [
            'class' => 'btn btn-primary-modern btn-modern btn-lg animate-pulse'
        ]) ?>
    </div>
</div>
