<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\models\Barbershop;
use app\models\Employee;
use app\models\Service;

class PublicController extends Controller
{
    public $layout = 'main';

    public function actionBarbershop($id)
    {
        $barbershop = Barbershop::findOne($id);
        if (!$barbershop) {
            throw new NotFoundHttpException('Barbearia não encontrada.');
        }

        $employees = Employee::find()
            ->where(['barbershop_id' => $barbershop->id, 'status' => Employee::STATUS_ACTIVE])
            ->orderBy(['name' => SORT_ASC])
            ->all();

        $services = Service::find()
            ->where(['barbershop_id' => $barbershop->id, 'status' => Service::STATUS_ACTIVE])
            ->orderBy(['name' => SORT_ASC])
            ->all();

        return $this->render('barbershop', compact('barbershop', 'employees', 'services'));
    }
}
