<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use yii\bootstrap5\Html;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);

// Buscar informações da empresa se estivermos na área pública específica
$empresa = null;
$empresa_id = Yii::$app->request->get('empresa_id');
if ($empresa_id) {
    $empresa = \app\models\Empresa::findOne($empresa_id);
}

$this->registerCss("
body {
    font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #f8fafc;
    min-height: 100vh;
    margin: 0;
    padding: 0;
    color: #1a202c;
}

.company-header {
    background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%);
    color: white;
    padding: 2rem 0;
    box-shadow: 0 4px 20px rgba(66, 153, 225, 0.3);
}

.company-header .container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 2rem;
    text-align: center;
}

.company-name {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    text-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.company-tagline {
    font-size: 1.2rem;
    opacity: 0.95;
    font-weight: 300;
}

.public-nav {
    background: white;
    padding: 1rem 0;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    border-bottom: 1px solid #e2e8f0;
}

.public-nav .container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 2rem;
    display: flex;
    justify-content: center;
    gap: 3rem;
}

.nav-link {
    color: #4a5568;
    text-decoration: none;
    font-weight: 500;
    font-size: 1rem;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.nav-link:hover {
    background: #edf2f7;
    color: #2d3748;
    transform: translateY(-1px);
}

.nav-link.active {
    background: #4299e1;
    color: white;
}

.public-content {
    max-width: 1200px;
    margin: 3rem auto;
    padding: 0 2rem;
    min-height: 60vh;
}

.content-card {
    background: white;
    border-radius: 12px;
    padding: 3rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    border: 1px solid #e2e8f0;
}

.company-footer {
    background: #2d3748;
    color: #a0aec0;
    padding: 2rem 0;
    margin-top: 4rem;
    text-align: center;
}

.company-footer .container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 2rem;
}

.company-contact {
    display: flex;
    justify-content: center;
    gap: 3rem;
    margin-bottom: 1rem;
    flex-wrap: wrap;
}

.contact-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.9rem;
}

@media (max-width: 768px) {
    .company-name {
        font-size: 2rem;
    }
    
    .public-nav .container {
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .nav-link {
        text-align: center;
        justify-content: center;
    }
    
    .public-content {
        margin: 1rem auto;
        padding: 0 1rem;
    }
    
    .content-card {
        padding: 1.5rem;
    }
    
    .company-contact {
        flex-direction: column;
        gap: 1rem;
    }
}
");
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<header class="company-header">
    <div class="container">
        <?php if ($empresa): ?>
            <h1 class="company-name"><?= Html::encode($empresa->nome) ?></h1>
            <p class="company-tagline">Agende seus serviços online</p>
        <?php else: ?>
            <h1 class="company-name">Área de Agendamentos</h1>
            <p class="company-tagline">Encontre a empresa ideal para você</p>
        <?php endif; ?>
    </div>
</header>

<nav class="public-nav">
    <div class="container">
        <?php if ($empresa): ?>
            <a href="<?= \yii\helpers\Url::to(['/cliente/area-publica', 'empresa_id' => $empresa->id]) ?>" class="nav-link">
                🏠 Início
            </a>
            <a href="<?= \yii\helpers\Url::to(['/cliente/area-publica', 'empresa_id' => $empresa->id]) ?>#servicos" class="nav-link">
                💼 Serviços
            </a>
            <a href="<?= \yii\helpers\Url::to(['/cliente/area-publica', 'empresa_id' => $empresa->id]) ?>#agendamento" class="nav-link">
                📅 Agendar
            </a>
            <a href="<?= \yii\helpers\Url::to(['/cliente/area-publica', 'empresa_id' => $empresa->id]) ?>#contato" class="nav-link">
                📧 Contato
            </a>
        <?php else: ?>
            <a href="<?= \yii\helpers\Url::to(['/cliente/empresas']) ?>" class="nav-link">
                🏠 Início
            </a>
            <a href="<?= \yii\helpers\Url::to(['/cliente/empresas']) ?>" class="nav-link">
                🏢 Empresas
            </a>
        <?php endif; ?>
    </div>
</nav>

<main class="public-content">
    <div class="content-card">
        <?= $content ?>
    </div>
</main>

<footer class="company-footer">
    <div class="container">
        <?php if ($empresa): ?>
            <div class="company-contact">
                <?php if ($empresa->telefone): ?>
                    <div class="contact-item">
                        📞 <?= Html::encode($empresa->telefone) ?>
                    </div>
                <?php endif; ?>
                <?php if ($empresa->email): ?>
                    <div class="contact-item">
                        ✉️ <?= Html::encode($empresa->email) ?>
                    </div>
                <?php endif; ?>
                <?php if ($empresa->endereco): ?>
                    <div class="contact-item">
                        📍 <?= Html::encode($empresa->endereco) ?>
                    </div>
                <?php endif; ?>
            </div>
            <p>&copy; <?= date('Y') ?> <?= Html::encode($empresa->nome) ?>. Todos os direitos reservados.</p>
        <?php else: ?>
            <p>&copy; <?= date('Y') ?> Sistema de Agendamentos. Todos os direitos reservados.</p>
        <?php endif; ?>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>