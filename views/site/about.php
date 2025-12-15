<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'Quem Somos';

$this->registerCss("
.about-section h1 {
    color: #2d3748;
    font-weight: 700;
    margin-bottom: 2rem;
    text-align: center;
}

.about-section h2 {
    color: #667eea;
    font-weight: 600;
    margin-top: 2rem;
    margin-bottom: 1rem;
}

.about-section p {
    color: #4a5568;
    line-height: 1.8;
    font-size: 1.1rem;
    margin-bottom: 1.5rem;
}

.values-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
    margin-top: 2rem;
}

.value-item {
    text-align: center;
    padding: 1.5rem;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
    border-radius: 10px;
}

.value-item h3 {
    color: #667eea;
    margin-bottom: 0.5rem;
}
");
?>
<div class="site-about about-section">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        Somos uma plataforma moderna de gestão organizacional, desenvolvida para simplificar 
        a administração de empresas, serviços e equipes. Nossa missão é proporcionar ferramentas 
        intuitivas e eficientes que facilitem o dia a dia de gestores e administradores.
    </p>

    <h2>Nossa Missão</h2>
    <p>
        Oferecer soluções tecnológicas que transformem a gestão empresarial, 
        tornando-a mais ágil, transparente e eficiente para organizações de todos os tamanhos.
    </p>

    <h2>Nossos Valores</h2>
    <div class="values-grid">
        <div class="value-item">
            <h3>🎯 Eficiência</h3>
            <p>Processos otimizados e resultados rápidos</p>
        </div>
        <div class="value-item">
            <h3>🔒 Segurança</h3>
            <p>Proteção de dados e privacidade garantidas</p>
        </div>
        <div class="value-item">
            <h3>💡 Inovação</h3>
            <p>Tecnologia de ponta sempre atualizada</p>
        </div>
    </div>
</div>
