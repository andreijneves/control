<?php

namespace app\modules\organization\controllers;

use app\models\Employee;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class EmployeeController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $user = Yii::$app->user->identity;
                            return $user->isAdmGeral() || $user->isAdmOrg() || ($user->isFuncionario() && $user->organization_id);
                        },
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $query = Employee::find();
        
        // Se não é admin geral, filtra pela organização
        if (!Yii::$app->user->identity->isAdmGeral()) {
            $query->andWhere(['organization_id' => Yii::$app->user->identity->organization_id]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ],
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);
        $this->checkAccess($model);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionCreate()
    {
        $model = new Employee(['scenario' => 'create']);
        
        // Define organização automaticamente se não for admin geral
        if (!Yii::$app->user->identity->isAdmGeral()) {
            $model->organization_id = Yii::$app->user->identity->organization_id;
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Funcionário criado com sucesso. Usuário de acesso criado automaticamente.');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $this->checkAccess($model);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Funcionário atualizado com sucesso.');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $this->checkAccess($model);
        
        $model->delete();

        Yii::$app->session->setFlash('success', 'Funcionário removido com sucesso.');
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Employee::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Funcionário não encontrado.');
    }

    protected function checkAccess($model)
    {
        $user = Yii::$app->user->identity;
        
        if (!$user->isAdmGeral() && $model->organization_id != $user->organization_id) {
            throw new NotFoundHttpException('Você não tem permissão para acessar este funcionário.');
        }
    }
}
