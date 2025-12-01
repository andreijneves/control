<?php

namespace app\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\models\Account;

class AccountController extends Controller
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
                        'matchCallback' => function () {
                            return Yii::$app->user->identity->role === Account::ROLE_ADMIN;
                        }
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $barbershopId = Yii::$app->user->identity->barbershop_id;
        $dataProvider = new ActiveDataProvider([
            'query' => Account::find()->where(['barbershop_id' => $barbershopId]),
            'pagination' => ['pageSize' => 20],
            'sort' => ['defaultOrder' => ['username' => SORT_ASC]],
        ]);
        return $this->render('index', compact('dataProvider'));
    }

    public function actionCreate()
    {
        $model = new Account();
        $model->barbershop_id = Yii::$app->user->identity->barbershop_id;
        $model->role = Account::ROLE_STAFF;
        if ($model->load(Yii::$app->request->post())) {
            if (!empty($password = Yii::$app->request->post('Account')['password'] ?? null)) {
                $model->setPassword($password);
            }
            $model->generateAuthKey();
            if ($model->save()) {
                return $this->redirect(['index']);
            }
        }
        return $this->render('create', compact('model'));
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            if (!empty($password = Yii::$app->request->post('Account')['password'] ?? null)) {
                $model->setPassword($password);
            }
            if ($model->save()) {
                return $this->redirect(['index']);
            }
        }
        return $this->render('update', compact('model'));
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        // prevent self-deletion
        if ($model->id === Yii::$app->user->id) {
            Yii::$app->session->setFlash('error', 'Você não pode excluir seu próprio usuário.');
        } else {
            $model->delete();
        }
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        $model = Account::findOne(['id' => $id, 'barbershop_id' => Yii::$app->user->identity->barbershop_id]);
        if (!$model) {
            throw new NotFoundHttpException('Usuário não encontrado.');
        }
        return $model;
    }
}
