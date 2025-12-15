<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\ContactForm;
use app\models\Organization;
use app\models\Employee;
use app\models\Service;

class SiteController extends Controller
{
    public function init()
    {
        parent::init();
        
        // Usa layout público para visitantes
        if (Yii::$app->user->isGuest) {
            $this->layout = 'public';
        }
    }

    /**
     * {@inheritdoc}
     */
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

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Exibe a página inicial.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (!Yii::$app->user->isGuest) {
            $user = Yii::$app->user->identity;
            
            // Dashboard para Administrador Geral
            if ($user->isAdmGeral()) {
                return $this->render('admin-dashboard', [
                    'totalOrganizations' => Organization::find()->count(),
                    'totalEmployees' => Employee::find()->count(),
                    'totalServices' => Service::find()->count(),
                    'organizations' => Organization::find()->orderBy(['created_at' => SORT_DESC])->limit(10)->all(),
                ]);
            }
            
            // Dashboard para Administrador de Organização ou Funcionário
            if (($user->isAdmOrg() || $user->isFuncionario()) && $user->organization_id) {
                return $this->render('org-dashboard', [
                    'organization' => $user->organization,
                ]);
            }
        }
        return $this->render('index');
    }

    /**
     * Ação de login.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        return $this->redirect(['/auth/auth/login']);
    }

    /**
     * Ação de logout.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Exibe a página de contato.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Exibe a página sobre.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Cadastro de nova organização.
     *
     * @return Response|string
     */
    public function actionRegister()
    {
        $model = new Organization();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $credentials = $model->getAdminCredentials();
            
            Yii::$app->session->setFlash('success', 
                "Organização cadastrada com sucesso!<br><br>" .
                "<strong>Credenciais do Administrador:</strong><br>" .
                "Usuário: <strong>{$credentials['username']}</strong><br>" .
                "Senha: <strong>{$credentials['password']}</strong><br><br>" .
                "<em>Guarde estas informações em local seguro!</em>"
            );

            return $this->redirect(['/auth/auth/login']);
        }

        return $this->render('register', [
            'model' => $model,
        ]);
    }
}
