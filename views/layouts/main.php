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
<?php
// Definir classe adicional baseada no tipo de usuário
$bodyClass = 'd-flex flex-column h-100';
if (!Yii::$app->user->isGuest) {
    $user = Yii::$app->user->identity;
    if ($user->isCliente()) {
        $bodyClass .= ' cliente-area';
    } elseif ($user->isAdminEmpresa()) {
        $bodyClass .= ' empresa-area';
    } elseif ($user->isAdmin()) {
        $bodyClass .= ' admin-area';
    }
}
?>
<body class="<?= $bodyClass ?>">
<?php $this->beginBody() ?>

<header id="header">
    <?php
    // Definir nome da aplicação baseado no contexto do usuário
    $appName = Yii::$app->name;
    if (!Yii::$app->user->isGuest && Yii::$app->user->identity->isCliente()) {
        $cliente = \app\models\Cliente::findOne(['usuario_id' => Yii::$app->user->identity->id]);
        if ($cliente && $cliente->empresa) {
            $appName = $cliente->empresa->nome . ' - Área do Cliente';
        }
    }
    
    // Definir cor do navbar baseada no tipo de usuário
    $navbarColor = 'dark';
    if (!Yii::$app->user->isGuest) {
        $user = Yii::$app->user->identity;
        if ($user->isCliente()) {
            $navbarColor = 'primary';
        } elseif ($user->isAdminEmpresa()) {
            $navbarColor = 'success';
        } elseif ($user->isAdmin()) {
            $navbarColor = 'danger';
        }
    }
    
    NavBar::begin([
        'brandLabel' => $appName,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => ['class' => 'navbar navbar-expand-md navbar-dark bg-' . $navbarColor . ' sticky-top'],
    ]);

    $menuItems = [];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Início', 'url' => ['/site/index']];
       // $menuItems[] = ['label' => '🏪 Área de Clientes', 'url' => ['/cliente/empresas']];
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
            $menuItems[] = ['label' => 'Logout (' . Html::encode($user->nome_completo ?: $user->username) . ')', 'url' => ['/site/logout'], 'linkOptions' => ['data-method' => 'post']];
        } elseif ($user->isCliente()) {
            $menuItems[] = ['label' => '🏠 Meu Painel', 'url' => ['/cliente/index']];
            $menuItems[] = ['label' => '📅 Meus Agendamentos', 'url' => ['/cliente/agendamentos']];
            
            // Para logout do cliente, redirecionar para área pública da empresa
            $cliente = \app\models\Cliente::findOne(['usuario_id' => $user->id]);
            $logoutUrl = ['/site/logout'];
            if ($cliente && $cliente->empresa_id) {
                $logoutUrl = ['/site/logout', 'redirect_to' => 'area-publica', 'empresa_id' => $cliente->empresa_id];
            }
            $menuItems[] = ['label' => 'Logout (' . Html::encode($user->nome_completo ?: $user->username) . ')', 'url' => $logoutUrl, 'linkOptions' => ['data-method' => 'post']];
        } else {
            $menuItems[] = ['label' => 'Logout (' . Html::encode($user->nome_completo ?: $user->username) . ')', 'url' => ['/site/logout'], 'linkOptions' => ['data-method' => 'post']];
        }
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

<footer id="footer" class="mt-auto py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 mb-4">
                <h5 class="text-white mb-3">🚀 Control</h5>
                <p class="text-white opacity-75">
                    Revolucionando a gestão de serviços com tecnologia moderna e design intuitivo. 
                    Sua empresa merece o melhor!
                </p>
                <div class="d-flex">
                    <a href="#" class="text-white me-3" style="font-size: 1.5rem;">📱</a>
                    <a href="#" class="text-white me-3" style="font-size: 1.5rem;">📧</a>
                    <a href="#" class="text-white me-3" style="font-size: 1.5rem;">🌐</a>
                </div>
            </div>
            
            <div class="col-lg-2 col-md-4 mb-4">
                <h6 class="text-white mb-3">📋 Produto</h6>
                <ul class="list-unstyled">
                    <li><a href="<?= \yii\helpers\Url::to(['/site/index']) ?>" class="text-white opacity-75 text-decoration-none">Início</a></li>
                    <li><a href="<?= \yii\helpers\Url::to(['/site/sobre']) ?>" class="text-white opacity-75 text-decoration-none">Sobre</a></li>
                    <li><a href="<?= \yii\helpers\Url::to(['/site/cadastro-empresa']) ?>" class="text-white opacity-75 text-decoration-none">Cadastrar Empresa</a></li>
                </ul>
            </div>
            
            <div class="col-lg-2 col-md-4 mb-4">
                <h6 class="text-white mb-3">🎯 Recursos</h6>
                <ul class="list-unstyled">
                    <li><span class="text-white opacity-75">Agendamentos</span></li>
                    <li><span class="text-white opacity-75">Dashboard</span></li>
                    <li><span class="text-white opacity-75">Relatórios</span></li>
                    <li><span class="text-white opacity-75">API</span></li>
                </ul>
            </div>
            
            <div class="col-lg-2 col-md-4 mb-4">
                <h6 class="text-white mb-3">🤝 Suporte</h6>
                <ul class="list-unstyled">
                    <li><a href="<?= \yii\helpers\Url::to(['/site/contato']) ?>" class="text-white opacity-75 text-decoration-none">Contato</a></li>
                    <li><span class="text-white opacity-75">FAQ</span></li>
                    <li><span class="text-white opacity-75">Documentação</span></li>
                </ul>
            </div>
            
            <div class="col-lg-2 mb-4">
                <h6 class="text-white mb-3">📞 Contato</h6>
                <p class="text-white opacity-75 mb-1">📧 contato@control.com</p>
                <p class="text-white opacity-75 mb-1">📱 (11) 99999-9999</p>
                <p class="text-white opacity-75">🕒 8h às 18h</p>
            </div>
        </div>
        
        <hr class="my-4" style="border-color: rgba(255,255,255,0.2);">
        
        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start">
                <span class="text-white opacity-75">&copy; Control <?= date('Y') ?> - Todos os direitos reservados</span>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <span class="text-white opacity-75">Feito com ❤️ para sua empresa</span>
            </div>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
