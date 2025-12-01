<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use app\models\SignupForm;

class AuthController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['register'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
        ];
    }

    public function actionRegister()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && ($account = $model->signup())) {
            Yii::$app->user->login($account);
            return $this->redirect(['dashboard/index']);
        }
        return $this->render('register', [
            'model' => $model,
        ]);
    }
}
