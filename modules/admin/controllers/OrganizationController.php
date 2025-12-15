<?php

namespace app\modules\admin\controllers;

use app\models\Organization;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class OrganizationController extends Controller
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
                            return Yii::$app->user->identity->isAdmGeral();
                        },
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Organization::find(),
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
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new Organization();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $creds = $model->getAdminCredentials();
            $msg = 'Organização criada com sucesso.';
            if (!empty($creds)) {
                $msg .= ' Usuário administrador criado: <strong>' . $creds['username'] . '</strong> com senha <strong>' . $creds['password'] . '</strong>.';
            }
            Yii::$app->session->setFlash('success', $msg);
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Organização atualizada com sucesso.');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();

        Yii::$app->session->setFlash('success', 'Organização removida com sucesso.');
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Organization::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Organização não encontrada.');
    }
}
