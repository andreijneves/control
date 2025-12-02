<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\models\Barbershop;
use app\models\Employee;
use app\models\Service;
use app\models\Appointment;
use app\models\EmployeeSchedule;

class PublicController extends Controller
{
    public $layout = 'main';

    public function actionBarbershop($id = null, $slug = null)
    {
        if ($slug) {
            $barbershop = Barbershop::find()->where(['slug' => $slug])->one();
        } else {
            $barbershop = Barbershop::findOne($id);
        }
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

    public function actionBook($id = null, $slug = null)
    {
        if ($slug) {
            $barbershop = Barbershop::find()->where(['slug' => $slug])->one();
        } else {
            $barbershop = Barbershop::findOne($id);
        }
        if (!$barbershop) {
            throw new NotFoundHttpException('Barbearia não encontrada.');
        }

        $model = new Appointment();
        $model->barbershop_id = $barbershop->id;
        $model->status = Appointment::STATUS_PENDING;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            // Verificar se há horário disponível
            $dayOfWeek = date('w', strtotime($model->appointment_date));
            $schedule = EmployeeSchedule::find()
                ->where([
                    'employee_id' => $model->employee_id,
                    'day_of_week' => $dayOfWeek,
                ])
                ->andWhere(['<=', 'start_time', $model->appointment_time])
                ->andWhere(['>=', 'end_time', $model->appointment_time])
                ->one();

            if (!$schedule) {
                $model->addError('appointment_time', 'Funcionário não disponível neste horário.');
            } else {
                // Verificar conflitos
                $conflict = Appointment::find()
                    ->where([
                        'employee_id' => $model->employee_id,
                        'appointment_date' => $model->appointment_date,
                        'appointment_time' => $model->appointment_time,
                    ])
                    ->andWhere(['!=', 'status', Appointment::STATUS_CANCELLED])
                    ->exists();

                if ($conflict) {
                    $model->addError('appointment_time', 'Este horário já está ocupado.');
                } else {
                    $model->save(false);
                    Yii::$app->session->setFlash('success', 'Agendamento realizado! Aguarde a confirmação.');
                    return $this->redirect(['barbershop', 'id' => $barbershop->id]);
                }
            }
        }

        $services = Service::find()
            ->where(['barbershop_id' => $barbershop->id, 'status' => Service::STATUS_ACTIVE])
            ->all();
        $employees = Employee::find()
            ->where(['barbershop_id' => $barbershop->id, 'status' => Employee::STATUS_ACTIVE])
            ->all();

        return $this->render('book', compact('barbershop', 'model', 'services', 'employees'));
    }
}
