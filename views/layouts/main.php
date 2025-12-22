<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
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
        'options' => ['class' => 'navbar navbar-expand-md navbar-dark bg-dark sticky-top'],
    ]);

    $menuItems = [];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Início', 'url' => ['/site/index']];
        $menuItems[] = ['label' => '🏪 Área de Clientes', 'url' => ['/cliente/empresas']];
        $menuItems[] = ['label' => 'Sobre', 'url' => ['/site/sobre']];
        $menuItems[] = ['label' => 'Contato', 'url' => ['/site/contato']];
        $menuItems[] = ['label' => '🏢 Cadastrar Empresa', 'url' => ['/site/cadastro-empresa']];
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login'], 'linkOptions' => ['class' => 'nav-link btn btn-primary text-white ms-2']];
    } else {
        $user = Yii::$app->user->identity;
        
        if ($user->isAdmin()) {
            $menuItems[] = ['label' => 'Dashboard', 'url' => ['/admin/index']];
            $menuItems[] = ['label' => 'Empresas', 'url' => ['/admin/empresas']];
            $menuItems[] = ['label' => 'Usuários', 'url' => ['/admin/usuarios']];
        } elseif ($user->isAdminEmpresa()) {
            $menuItems[] = ['label' => 'Dashboard', 'url' => ['/empresa/index']];
            $menuItems[] = ['label' => 'Serviços', 'url' => ['/empresa/servicos']];
            $menuItems[] = ['label' => 'Funcionários', 'url' => ['/empresa/funcionarios']];
            $menuItems[] = ['label' => 'Clientes', 'url' => ['/empresa/clientes']];
            $menuItems[] = ['label' => 'Agendamentos', 'url' => ['/empresa/agendamentos']];
            $menuItems[] = [
                'label' => '🌐 Área Pública',
                'items' => [
                    ['label' => '👁️ Visualizar Área Pública', 'url' => ['/cliente/area-publica', 'empresa_id' => $user->empresa_id], 'linkOptions' => ['target' => '_blank']],
                    '<div class="dropdown-divider"></div>',
                    ['label' => '📋 Configurações Gerais', 'url' => ['/empresa/configuracoes']],
                ],
            ];
        } elseif ($user->isCliente()) {
            $menuItems[] = ['label' => 'Meu Painel', 'url' => ['/cliente/index']];
            
            // Buscar empresa do cliente
            $cliente = \app\models\Cliente::findOne(['usuario_id' => $user->id]);
            if ($cliente && $cliente->empresa_id) {
                $menuItems[] = ['label' => 'Novo Agendamento', 'url' => ['/cliente/area-publica', 'empresa_id' => $cliente->empresa_id]];
            }
        }

        $menuItems[] = ['label' => 'Logout (' . Html::encode($user->nome_completo ?: $user->username) . ')', 'url' => ['/site/logout'], 'linkOptions' => ['data-method' => 'post']];
    }

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav ms-auto'],
        'items' => $menuItems,
    ]);

    NavBar::end();
    ?>
</header>

<main id="main" class="flex-shrink-0" role="main">
    <div class="container">
        <?php
        if (!empty($this->params['breadcrumbs'])) {
            echo \yii\bootstrap5\Breadcrumbs::widget([
                'links' => $this->params['breadcrumbs'],
            ]);
        }
        ?>
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
