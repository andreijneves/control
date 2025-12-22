<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Empresa;
use app\models\Usuario;
use yii\helpers\Html;

class SiteController extends Controller
{
    public function beforeAction($action)
    {
        // Desabilitar CSRF para ações públicas ou de logout
        if (in_array($action->id, ['contato', 'logout'])) {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Página inicial
     */
    public function actionIndex()
    {
        if (!Yii::$app->user->isGuest) {
            $user = Yii::$app->user->identity;
            
            if ($user->isAdmin()) {
                return $this->redirect(['admin/index']);
            } elseif ($user->isAdminEmpresa()) {
                return $this->redirect(['empresa/index']);
            } elseif ($user->isCliente()) {
                return $this->redirect(['cliente/index']);
            }
        }

        return $this->render('index');
    }

    /**
     * Login
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goHome();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    /**
     * Cadastro de empresa
     */
    public function actionCadastroEmpresa()
    {
        $model = new Empresa();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // Criar usuário admin da empresa
            $usuario = new Usuario();
            $usuario->username = $model->email; // Username sempre igual ao email do formulário
            $usuario->email = $model->email;
            $usuario->setPassword(Yii::$app->request->post('senha'));
            $usuario->generateAuthKey();
            $usuario->role = Usuario::ROLE_ADMIN_EMPRESA;
            $usuario->empresa_id = $model->id;
            $usuario->nome_completo = Yii::$app->request->post('responsavel');
            $usuario->status = 1;
            
            if ($usuario->save()) {
                // Capturar a senha para mostrar no flash
                $senhaTemporaria = Yii::$app->request->post('senha');
                
                // Flash com dados de acesso
                Yii::$app->session->setFlash('success', 
                    '<h5>🎉 Empresa cadastrada com sucesso!</h5>' .
                    '<div class="alert alert-warning mt-3">' .
                        '<strong>📋 DADOS DE ACESSO - ANOTE COM CUIDADO:</strong><br><br>' .
                        '<strong>👤 Usuário:</strong> ' . Html::encode($usuario->username) . '<br>' .
                        '<strong>🔑 Senha:</strong> ' . Html::encode($senhaTemporaria) . '<br>' .
                        '<strong>📧 E-mail:</strong> ' . Html::encode($usuario->email) . '<br><br>' .
                        '<small class="text-muted">⚠️ Guarde essas informações em local seguro! Você precisará delas para fazer login.</small>' .
                    '</div>'
                );
                return $this->redirect(['login']);
            } else {
                $model->delete(); // Desfazer criação da empresa se usuário falhou
                Yii::$app->session->setFlash('error', 'Erro ao criar usuário administrativo: ' . implode(', ', $usuario->getFirstErrors()));
            }
        }

        return $this->render('cadastro-empresa', [
            'model' => $model,
        ]);
    }

    /**
     * Página de contato
     */
    public function actionContato()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('success', 'Obrigado pela sua mensagem. Entraremos em contato com você em breve.');
            return $this->refresh();
        }
        return $this->render('contato', [
            'model' => $model,
        ]);
    }

    /**
     * Sobre
     */
    public function actionSobre()
    {
        return $this->render('sobre');
    }
}
