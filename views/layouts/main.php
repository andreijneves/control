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
