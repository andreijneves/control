<?php

namespace app\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\models\Service;

class ServiceController extends Controller
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
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $barbershopId = Yii::$app->user->identity->barbershop_id;
        $dataProvider = new ActiveDataProvider([
            'query' => Service::find()->where(['barbershop_id' => $barbershopId]),
            'pagination' => ['pageSize' => 20],
            'sort' => ['defaultOrder' => ['name' => SORT_ASC]],
        ]);
        return $this->render('index', compact('dataProvider'));
    }

    public function actionCreate()
    {
        $model = new Service();
        $model->barbershop_id = Yii::$app->user->identity->barbershop_id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }
        return $this->render('create', compact('model'));
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }
        return $this->render('update', compact('model'));
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        $model = Service::findOne(['id' => $id, 'barbershop_id' => Yii::$app->user->identity->barbershop_id]);
        if (!$model) {
            throw new NotFoundHttpException('Serviço não encontrado.');
        }
        return $model;
    }
}
