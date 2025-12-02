<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header id="header">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => ['class' => 'navbar-expand-md navbar-dark bg-dark fixed-top']
    ]);
    $items = [];
    if (Yii::$app->user->isGuest) {
        $items[] = ['label' => 'Login', 'url' => ['/site/login']];
        $items[] = ['label' => 'Cadastrar', 'url' => ['/auth/register']];
        $items[] = ['label' => 'Admin', 'url' => ['/admin-auth/login']];
    } else {
        $items[] = ['label' => 'Dashboard', 'url' => ['/dashboard/index']];
        $items[] = ['label' => 'Funcionários', 'url' => ['/employee/index']];
        $items[] = ['label' => 'Serviços', 'url' => ['/service/index']];
        $items[] = ['label' => 'Agendamentos', 'url' => ['/appointment/index']];
        $items[] = ['label' => 'Usuários', 'url' => ['/account/index']];
        $barbershopId = Yii::$app->user->identity->barbershop_id ?? null;
        $slug = null;
        if ($barbershopId) {
            $bs = \app\models\Barbershop::findOne($barbershopId);
            if ($bs && $bs->slug) { $slug = $bs->slug; }
        }
        if ($barbershopId || $slug) {
            $url = $slug ? ['/public/barbershop', 'slug' => $slug] : ['/public/barbershop', 'id' => $barbershopId];
            $items[] = ['label' => 'Página Pública', 'url' => $url, 'linkOptions' => ['target' => '_blank']];
        }
        $items[] = '<li class="nav-item">'
            . Html::beginForm(['/site/logout'])
            . Html::submitButton(
                'Sair (' . Yii::$app->user->identity->username . ')',
                ['class' => 'nav-link btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'items' => $items,
    ]);
    NavBar::end();
    ?>
</header>

<main id="main" class="flex-shrink-0" role="main">
    <div class="container">
        <?php if (!empty($this->params['breadcrumbs'])): ?>
            <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
        <?php endif ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<footer id="footer" class="mt-auto py-3 bg-light">
    <div class="container">
        <div class="row text-muted">
            <div class="col-md-6 text-center text-md-start">&copy; My Company <?= date('Y') ?></div>
            <div class="col-md-6 text-center text-md-end"><?= Yii::powered() ?></div>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
