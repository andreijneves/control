<?php
// Teste CSRF simples

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../config/web.php';
$app = new yii\web\Application($config);

// Simular uma requisição POST
$_SERVER['REQUEST_METHOD'] = 'POST';
$_SERVER['REQUEST_URI'] = '/site/cadastro-empresa';

echo "Teste CSRF Token:<br>";
echo "Request Component: " . get_class(Yii::$app->request) . "<br>";
echo "Has CSRF Token Method: " . (method_exists(Yii::$app->request, 'getCsrfToken') ? 'SIM' : 'NÃO') . "<br>";

try {
    $token = Yii::$app->request->getCsrfToken();
    echo "CSRF Token gerado: " . substr($token, 0, 20) . "...<br>";
    echo "<br><strong>✓ CSRF está funcionando!</strong>";
} catch (Exception $e) {
    echo "Erro ao gerar CSRF Token: " . $e->getMessage() . "<br>";
}
?>
