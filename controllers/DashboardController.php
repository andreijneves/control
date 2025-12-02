<?php

namespace app\controllers;

use yii\filters\AccessControl;
use yii\web\Controller;
use Yii;
use app\models\Employee;
use app\models\Service;
use app\models\Account;
use app\models\Barbershop;

class DashboardController extends Controller
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
        $barbershopId = Yii::$app->user->identity->barbershop_id ?? null;
        $barbershop = $barbershopId ? Barbershop::findOne($barbershopId) : null;

        $employeesCount = $barbershopId ? (int) Employee::find()->where(['barbershop_id' => $barbershopId])->count() : 0;
        $servicesCount = $barbershopId ? (int) Service::find()->where(['barbershop_id' => $barbershopId])->count() : 0;
        $usersCount = $barbershopId ? (int) Account::find()->where(['barbershop_id' => $barbershopId])->count() : 0;

        $recentEmployees = $barbershopId
            ? Employee::find()->where(['barbershop_id' => $barbershopId])->orderBy(['created_at' => SORT_DESC])->limit(5)->all()
            : [];
        $recentServices = $barbershopId
            ? Service::find()->where(['barbershop_id' => $barbershopId])->orderBy(['created_at' => SORT_DESC])->limit(5)->all()
            : [];

        return $this->render('index', compact(
            'barbershop',
            'employeesCount',
            'servicesCount',
            'usersCount',
            'recentEmployees',
            'recentServices'
        ));
    }
}
