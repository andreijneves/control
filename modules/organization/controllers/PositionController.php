<?php

namespace app\modules\organization\controllers;

use app\models\Position;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

class PositionController extends Controller
{
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'allow' => true,
                            'matchCallback' => function ($rule, $action) {
                                $user = Yii::$app->user->identity;
                                return $user && (
                                    $user->isAdmGeral() || 
                                    ($user->isAdmOrg() && $user->organization_id) ||
                                    ($user->isFuncionario() && $user->organization_id)
                                );
                            },
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lista todos os cargos.
     */
    public function actionIndex()
    {
        $query = Position::find();
        
        $user = Yii::$app->user->identity;
        if (!$user->isAdmGeral() && $user->organization_id) {
            $query->andWhere(['organization_id' => $user->organization_id]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query->orderBy(['created_at' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Exibe um cargo específico.
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $this->checkAccess($model);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Cria um novo cargo.
     */
    public function actionCreate()
    {
        $model = new Position();
        
        $user = Yii::$app->user->identity;
        if (!$user->isAdmGeral() && $user->organization_id) {
            $model->organization_id = $user->organization_id;
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Cargo criado com sucesso.');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Atualiza um cargo existente.
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $this->checkAccess($model);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Cargo atualizado com sucesso.');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deleta um cargo.
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $this->checkAccess($model);
        
        $model->delete();
        Yii::$app->session->setFlash('success', 'Cargo excluído com sucesso.');

        return $this->redirect(['index']);
    }

    /**
     * Encontra o modelo baseado no ID.
     */
    protected function findModel($id)
    {
        if (($model = Position::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('O cargo solicitado não existe.');
    }

    /**
     * Verifica se o usuário tem acesso ao cargo.
     */
    protected function checkAccess($model)
    {
        $user = Yii::$app->user->identity;
        
        if ($user->isAdmGeral()) {
            return true;
        }

        if ($model->organization_id != $user->organization_id) {
            throw new NotFoundHttpException('Você não tem permissão para acessar este cargo.');
        }

        return true;
    }
}
