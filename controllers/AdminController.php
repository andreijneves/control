<?php

namespace app\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\models\Barbershop;
use app\models\Account;

class AdminController extends Controller
{
    public $layout = 'admin';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'user' => 'adminUser',
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function () {
                            return !Yii::$app->adminUser->isGuest;
                        }
                    ],
                ],
            ],
        ];
    }

    public function actionDashboard()
    {
        $barbershopsCount = Barbershop::find()->count();
        $accountsCount = Account::find()->count();
        
        $recentBarbershops = Barbershop::find()
            ->orderBy(['created_at' => SORT_DESC])
            ->limit(10)
            ->all();

        return $this->render('dashboard', compact('barbershopsCount', 'accountsCount', 'recentBarbershops'));
    }

    public function actionBarbershops()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Barbershop::find(),
            'pagination' => ['pageSize' => 20],
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
        ]);
        return $this->render('barbershops', compact('dataProvider'));
    }

    public function actionViewBarbershop($id)
    {
        $barbershop = $this->findBarbershop($id);
        
        $accountsProvider = new ActiveDataProvider([
            'query' => Account::find()->where(['barbershop_id' => $id]),
            'pagination' => ['pageSize' => 10],
        ]);

        return $this->render('view-barbershop', compact('barbershop', 'accountsProvider'));
    }

    public function actionCreateBarbershop()
    {
        $model = new Barbershop();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Barbearia criada com sucesso.');
            return $this->redirect(['view-barbershop', 'id' => $model->id]);
        }
        return $this->render('create-barbershop', compact('model'));
    }

    public function actionUpdateBarbershop($id)
    {
        $model = $this->findBarbershop($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Barbearia atualizada com sucesso.');
            return $this->redirect(['view-barbershop', 'id' => $model->id]);
        }
        return $this->render('update-barbershop', compact('model'));
    }

    public function actionDeleteBarbershop($id)
    {
        $model = $this->findBarbershop($id);
        $model->delete();
        Yii::$app->session->setFlash('success', 'Barbearia excluída com sucesso.');
        return $this->redirect(['barbershops']);
    }

    protected function findBarbershop($id)
    {
        $model = Barbershop::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException('Barbearia não encontrada.');
        }
        return $model;
    }
}
