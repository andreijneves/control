<?php

namespace app\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\models\Appointment;

class AppointmentController extends Controller
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
            'query' => Appointment::find()
                ->where(['barbershop_id' => $barbershopId])
                ->with(['service', 'employee']),
            'pagination' => ['pageSize' => 20],
            'sort' => ['defaultOrder' => ['appointment_date' => SORT_DESC, 'appointment_time' => SORT_DESC]],
        ]);
        return $this->render('index', compact('dataProvider'));
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view', compact('model'));
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Agendamento atualizado com sucesso.');
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', compact('model'));
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();
        return $this->redirect(['index']);
    }

    public function actionConfirm($id)
    {
        $model = $this->findModel($id);
        $model->status = Appointment::STATUS_CONFIRMED;
        $model->save(false);
        Yii::$app->session->setFlash('success', 'Agendamento confirmado.');
        return $this->redirect(['index']);
    }

    public function actionCancel($id)
    {
        $model = $this->findModel($id);
        $model->status = Appointment::STATUS_CANCELLED;
        $model->save(false);
        Yii::$app->session->setFlash('info', 'Agendamento cancelado.');
        return $this->redirect(['index']);
    }

    public function actionComplete($id)
    {
        $model = $this->findModel($id);
        $model->status = Appointment::STATUS_COMPLETED;
        $model->save(false);
        Yii::$app->session->setFlash('success', 'Agendamento marcado como concluído.');
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        $model = Appointment::findOne(['id' => $id, 'barbershop_id' => Yii::$app->user->identity->barbershop_id]);
        if (!$model) {
            throw new NotFoundHttpException('Agendamento não encontrado.');
        }
        return $model;
    }
}
