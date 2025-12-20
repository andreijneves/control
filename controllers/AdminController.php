<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use app\models\Empresa;
use app\models\Usuario;
use app\models\Funcionario;
use app\models\Servico;

class AdminController extends Controller
{
    public function beforeAction($action)
    {
        // CSRF está habilitado por padrão
        return parent::beforeAction($action);
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function () {
                            return Yii::$app->user->identity->isAdmin();
                        }
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $totalEmpresas = Empresa::find()->count();
        $totalUsuarios = Usuario::find()->count();
        $totalFuncionarios = Funcionario::find()->count();
        $totalServicos = Servico::find()->count();

        return $this->render('index', [
            'totalEmpresas' => $totalEmpresas,
            'totalUsuarios' => $totalUsuarios,
            'totalFuncionarios' => $totalFuncionarios,
            'totalServicos' => $totalServicos,
        ]);
    }

    public function actionEmpresas()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Empresa::find(),
            'pagination' => ['pageSize' => 20],
        ]);

        return $this->render('empresas', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCriarEmpresa()
    {
        $model = new Empresa();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Empresa criada com sucesso!');
            return $this->redirect(['empresas']);
        }

        return $this->render('criar-empresa', [
            'model' => $model,
        ]);
    }

    public function actionEditarEmpresa($id)
    {
        $model = Empresa::findOne($id);
        if (!$model) {
            throw new \yii\web\NotFoundHttpException('Empresa não encontrada.');
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Empresa atualizada com sucesso!');
            return $this->redirect(['empresas']);
        }

        return $this->render('editar-empresa', [
            'model' => $model,
        ]);
    }

    public function actionDeletarEmpresa($id)
    {
        $model = Empresa::findOne($id);
        if (!$model) {
            throw new \yii\web\NotFoundHttpException('Empresa não encontrada.');
        }

        $model->delete();
        Yii::$app->session->setFlash('success', 'Empresa deletada com sucesso!');
        return $this->redirect(['empresas']);
    }
}
