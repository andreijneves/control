<?php

namespace app\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\models\Employee;
use app\models\EmployeeSchedule;

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
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $barbershopId = Yii::$app->user->identity->barbershop_id;
        $dataProvider = new ActiveDataProvider([
            'query' => Employee::find()->where(['barbershop_id' => $barbershopId]),
            'pagination' => ['pageSize' => 20],
            'sort' => ['defaultOrder' => ['name' => SORT_ASC]],
        ]);
        return $this->render('index', compact('dataProvider'));
    }

    public function actionCreate()
    {
        $model = new Employee();
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

    public function actionSchedule($id)
    {
        $employee = $this->findModel($id);
        $dataProvider = new ActiveDataProvider([
            'query' => EmployeeSchedule::find()->where(['employee_id' => $employee->id]),
            'pagination' => false,
            'sort' => ['defaultOrder' => ['day_of_week' => SORT_ASC, 'start_time' => SORT_ASC]],
        ]);
        return $this->render('schedule', compact('employee', 'dataProvider'));
    }

    public function actionAddSchedule($id)
    {
        $employee = $this->findModel($id);
        $model = new EmployeeSchedule();
        $model->employee_id = $employee->id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['schedule', 'id' => $employee->id]);
        }
        return $this->render('add-schedule', compact('employee', 'model'));
    }

    public function actionDeleteSchedule($id, $scheduleId)
    {
        $employee = $this->findModel($id);
        $schedule = EmployeeSchedule::findOne(['id' => $scheduleId, 'employee_id' => $employee->id]);
        if ($schedule) {
            $schedule->delete();
        }
        return $this->redirect(['schedule', 'id' => $employee->id]);
    }

    protected function findModel($id)
    {
        $model = Employee::findOne(['id' => $id, 'barbershop_id' => Yii::$app->user->identity->barbershop_id]);
        if (!$model) {
            throw new NotFoundHttpException('Funcionário não encontrado.');
        }
        return $model;
    }
}
