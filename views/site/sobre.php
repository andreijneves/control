<?php

use yii\bootstrap5\Html;

$this->title = 'Sobre - Control';
$this->params['breadcrumbs'][] = $this->title;
?>

<!-- Hero Section da página Sobre -->
<div class="hero-section" style="min-height: 50vh;">
    <div class="container">
        <div class="hero-content">
            <h1 class="display-4">💡 Sobre o Control</h1>
            <p class="lead">A revolução na gestão de serviços chegou</p>
        </div>
    </div>
</div>

<div class="container my-5">
    <div class="row align-items-center mb-5">
        <div class="col-lg-6">
            <h2 class="text-white fw-bold mb-4">🎯 Nossa Missão</h2>
            <p class="text-white opacity-75 fs-5">
                Simplificar a vida de empresários e empreendedores, oferecendo uma plataforma 
                completa e intuitiva para gerenciar agendamentos, clientes e serviços.
            </p>
            <p class="text-white opacity-75">
                Acreditamos que a tecnologia deve trabalhar para você, não contra você. 
                Por isso criamos o Control: uma solução que automatiza tarefas repetitivas 
                e libera seu tempo para focar no crescimento do negócio.
            </p>
        </div>
        <div class="col-lg-6">
            <div class="feature-card text-center">
                <div class="feature-icon">🚀</div>
                <h5>Inovação Constante</h5>
                <p>Sempre evoluindo para atender melhor suas necessidades</p>
            </div>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-lg-4 mb-4">
            <div class="feature-card text-center h-100">
                <div class="feature-icon">🎨</div>
                <h5>Design Intuitivo</h5>
                <p>Interface moderna e fácil de usar, criada pensando na experiência do usuário</p>
            </div>
        </div>
        <div class="col-lg-4 mb-4">
            <div class="feature-card text-center h-100">
                <div class="feature-icon">🔒</div>
                <h5>Segurança Total</h5>
                <p>Seus dados protegidos com as melhores práticas de segurança digital</p>
            </div>
        </div>
        <div class="col-lg-4 mb-4">
            <div class="feature-card text-center h-100">
                <div class="feature-icon">📱</div>
                <h5>Totalmente Responsivo</h5>
                <p>Acesse de qualquer dispositivo: computador, tablet ou smartphone</p>
            </div>
        </div>
    </div>

    <div class="stats-section">
        <div class="container">
            <h3 class="text-center text-white mb-4">📊 Nossos Números</h3>
            <div class="row text-center">
                <div class="col-md-3 col-6">
                    <div class="stat-card">
                        <span class="stat-number">100%</span>
                        <span class="stat-label">Dedicação</span>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-card">
                        <span class="stat-number">10k+</span>
                        <span class="stat-label">Agendamentos/Mês</span>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-card">
                        <span class="stat-number">99.9%</span>
                        <span class="stat-label">Uptime</span>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-card">
                        <span class="stat-number">4.9★</span>
                        <span class="stat-label">Avaliação</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center my-5">
        <h3 class="text-white mb-4">🤝 Pronto para Começar?</h3>
        <p class="text-white opacity-75 mb-4">
            Experimente nosso sistema e transforme a gestão do seu negócio
        </p>
        <?= Html::a('<span>🚀 Cadastrar Minha Empresa</span>', ['/site/cadastro-empresa'], [
            'class' => 'btn btn-primary-modern btn-modern btn-lg'
        ]) ?>
    </div>
</div>
