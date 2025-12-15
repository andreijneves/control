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

$this->registerCss("
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
    margin: 0;
    padding: 0;
}

.public-navbar {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    padding: 1rem 0;
    box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
}

.public-navbar .container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 2rem;
}

.public-brand {
    font-size: 1.8rem;
    font-weight: 700;
    color: #4a5568;
    text-decoration: none;
    transition: color 0.3s ease;
}

.public-brand:hover {
    color: #667eea;
}

.public-nav {
    display: flex;
    gap: 2rem;
    align-items: center;
    list-style: none;
    margin: 0;
    padding: 0;
}

.public-nav a {
    color: #4a5568;
    text-decoration: none;
    font-weight: 500;
    font-size: 1rem;
    transition: all 0.3s ease;
    padding: 0.5rem 1rem;
    border-radius: 6px;
}

.public-nav a:hover {
    color: #667eea;
    background: rgba(102, 126, 234, 0.1);
}

.public-nav .btn-login {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 0.6rem 1.8rem;
    border-radius: 25px;
    font-weight: 600;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
}

.public-nav .btn-login:hover {
    background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
    color: white;
}

.public-content {
    max-width: 1200px;
    margin: 3rem auto;
    padding: 0 2rem;
}

.public-card {
    background: white;
    border-radius: 15px;
    padding: 3rem;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
}

.public-footer {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    padding: 2rem 0;
    margin-top: 4rem;
    color: #4a5568;
    text-align: center;
    box-shadow: 0 -2px 20px rgba(0, 0, 0, 0.1);
}

.public-footer a {
    color: #667eea;
    text-decoration: none;
}

.public-footer a:hover {
    text-decoration: underline;
}

@media (max-width: 768px) {
    .public-navbar .container {
        flex-direction: column;
        gap: 1rem;
    }
    
    .public-nav {
        flex-direction: column;
        gap: 0.5rem;
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

<nav class="public-navbar">
    <div class="container">
        <a href="<?= Yii::$app->homeUrl ?>" class="public-brand">
            <?= Yii::$app->name ?>
        </a>
        <ul class="public-nav">
            <li><a href="<?= \yii\helpers\Url::to(['/site/index']) ?>">Início</a></li>
            <li><a href="<?= \yii\helpers\Url::to(['/site/about']) ?>">Quem Somos</a></li>
            <li><a href="<?= \yii\helpers\Url::to(['/site/contact']) ?>">Contato</a></li>
            <li><a href="<?= \yii\helpers\Url::to(['/site/register']) ?>">Cadastro</a></li>
            <li><a href="<?= \yii\helpers\Url::to(['/auth/auth/login']) ?>" class="btn-login">Acessar Sistema</a></li>
        </ul>
    </div>
</nav>

<div class="public-content">
    <div class="public-card">
        <?= $content ?>
    </div>
</div>

<footer class="public-footer">
    <div class="container">
        <p>&copy; <?= date('Y') ?> <?= Yii::$app->name ?>. Todos os direitos reservados.</p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
