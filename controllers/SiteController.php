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
            $usuario->username = $model->nome . '_admin';
            $usuario->email = $model->email;
            $usuario->setPassword(Yii::$app->request->post('senha'));
            $usuario->generateAuthKey();
            $usuario->role = Usuario::ROLE_ADMIN_EMPRESA;
            $usuario->empresa_id = $model->id;
            $usuario->nome_completo = Yii::$app->request->post('responsavel');
            $usuario->status = 1;
            
            if ($usuario->save()) {
                Yii::$app->session->setFlash('success', 'Empresa cadastrada com sucesso! Faça login para começar.');
                return $this->redirect(['login']);
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
