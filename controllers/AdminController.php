<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use app\models\Empresa;
use app\models\Usuario;
use app\models\Funcionario;
use app\models\Servico;
use app\models\Cliente;
use app\models\Agendamento;
use app\models\Horario;

class AdminController extends Controller
{
    public function beforeAction($action)
    {
        return parent::beforeAction($action);
    }

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
                            return Yii::$app->user->identity->isAdmin();
                        }
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $totalEmpresas = Empresa::find()->count();
        $totalUsuarios = Usuario::find()->count();
        $totalFuncionarios = Funcionario::find()->count();
        $totalServicos = Servico::find()->count();

        return $this->render('index', [
            'totalEmpresas' => $totalEmpresas,
            'totalUsuarios' => $totalUsuarios,
            'totalFuncionarios' => $totalFuncionarios,
            'totalServicos' => $totalServicos,
        ]);
    }

    public function actionEmpresas()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Empresa::find(),
            'pagination' => ['pageSize' => 20],
        ]);

        return $this->render('empresas', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCriarEmpresa()
    {
        $model = new Empresa();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Empresa criada com sucesso!');
            return $this->redirect(['empresas']);
        }

        return $this->render('criar-empresa', [
            'model' => $model,
        ]);
    }

    public function actionEditarEmpresa($id)
    {
        $model = Empresa::findOne($id);
        if (!$model) {
            throw new \yii\web\NotFoundHttpException('Empresa não encontrada.');
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Empresa atualizada com sucesso!');
            return $this->redirect(['empresas']);
        }

        return $this->render('editar-empresa', [
            'model' => $model,
        ]);
    }

    public function actionDeletarEmpresa($id)
    {
        $model = Empresa::findOne($id);
        if (!$model) {
            throw new \yii\web\NotFoundHttpException('Empresa não encontrada.');
        }

        try {
            // Debug: log para verificar se a ação está sendo executada
            Yii::info("Tentando deletar empresa ID: $id, Nome: {$model->nome}", __METHOD__);
            
            // Contar registros relacionados para informar o usuário
            $countUsuarios = Usuario::find()->where(['empresa_id' => $id])->count();
            $countClientes = Cliente::find()->where(['empresa_id' => $id])->count();
            $countFuncionarios = Funcionario::find()->where(['empresa_id' => $id])->count();
            $countServicos = Servico::find()->where(['empresa_id' => $id])->count();
            
            // Debug: mostrar contadores
            Yii::info("Contadores - Usuários: $countUsuarios, Clientes: $countClientes, Funcionários: $countFuncionarios, Serviços: $countServicos", __METHOD__);
            
            $empresaNome = $model->nome;
            $transaction = Yii::$app->db->beginTransaction();
            
            try {
                // Exclusão em cascata - deletar todos os registros relacionados
                
                // 1. Deletar agendamentos dos clientes desta empresa
                $agendamentosCount = 0;
                $clientes = Cliente::find()->where(['empresa_id' => $id])->all();
                foreach ($clientes as $cliente) {
                    $agendamentosCount += Agendamento::find()->where(['cliente_id' => $cliente->id])->count();
                    Agendamento::deleteAll(['cliente_id' => $cliente->id]);
                }
                
                // 2. Deletar horários dos funcionários desta empresa
                $horariosCount = 0;
                $funcionarios = Funcionario::find()->where(['empresa_id' => $id])->all();
                foreach ($funcionarios as $funcionario) {
                    $horariosCount += Horario::find()->where(['funcionario_id' => $funcionario->id])->count();
                    Horario::deleteAll(['funcionario_id' => $funcionario->id]);
                }
                
                // 3. Deletar clientes
                Cliente::deleteAll(['empresa_id' => $id]);
                
                // 4. Deletar funcionários
                Funcionario::deleteAll(['empresa_id' => $id]);
                
                // 5. Deletar serviços
                Servico::deleteAll(['empresa_id' => $id]);
                
                // 6. Deletar usuários
                Usuario::deleteAll(['empresa_id' => $id]);
                
                // 7. Finalmente deletar a empresa
                if ($model->delete()) {
                    $transaction->commit();
                    
                    $detalhes = [];
                    if ($countUsuarios > 0) $detalhes[] = "$countUsuarios usuário(s)";
                    if ($countClientes > 0) $detalhes[] = "$countClientes cliente(s)";
                    if ($countFuncionarios > 0) $detalhes[] = "$countFuncionarios funcionário(s)";
                    if ($countServicos > 0) $detalhes[] = "$countServicos serviço(s)";
                    if ($agendamentosCount > 0) $detalhes[] = "$agendamentosCount agendamento(s)";
                    if ($horariosCount > 0) $detalhes[] = "$horariosCount horário(s)";
                    
                    $mensagem = "Empresa '{$empresaNome}' deletada com sucesso!";
                    if (!empty($detalhes)) {
                        $mensagem .= " Também foram removidos: " . implode(', ', $detalhes) . ".";
                    }
                    
                    Yii::info("Empresa deletada com sucesso: $empresaNome", __METHOD__);
                    Yii::$app->session->setFlash('success', $mensagem);
                } else {
                    $transaction->rollBack();
                    $errors = $model->getFirstErrors();
                    Yii::error("Erro ao deletar empresa: " . print_r($errors, true), __METHOD__);
                    Yii::$app->session->setFlash('error', 'Erro ao deletar empresa: ' . implode(', ', $errors));
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            }
            
        } catch (\Exception $e) {
            Yii::error("Exception ao deletar empresa: " . $e->getMessage(), __METHOD__);
            Yii::$app->session->setFlash('error', 'Erro ao deletar empresa: ' . $e->getMessage());
        }

        return $this->redirect(['empresas']);
    }

    public function actionUsuarios()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Usuario::find()->orderBy(['created_at' => SORT_DESC]),
            'pagination' => ['pageSize' => 20],
        ]);

        return $this->render('usuarios', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCriarUsuario()
    {
        $model = new Usuario();

        if ($model->load(Yii::$app->request->post())) {
            $password = Yii::$app->request->post('password');
            if (!empty($password)) {
                $model->setPassword($password);
            }
            $model->generateAuthKey();
            
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Usuário criado com sucesso!');
                return $this->redirect(['usuarios']);
            }
        }

        return $this->render('criar-usuario', [
            'model' => $model,
        ]);
    }

    public function actionEditarUsuario($id)
    {
        $model = Usuario::findOne($id);
        if (!$model) {
            throw new \yii\web\NotFoundHttpException('Usuário não encontrado.');
        }

        if ($model->load(Yii::$app->request->post())) {
            $password = Yii::$app->request->post('password');
            if (!empty($password)) {
                $model->setPassword($password);
            }
            
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Usuário atualizado com sucesso!');
                return $this->redirect(['usuarios']);
            }
        }

        return $this->render('editar-usuario', [
            'model' => $model,
        ]);
    }

    public function actionAlterarStatusUsuario($id, $status)
    {
        $model = Usuario::findOne($id);
        if (!$model) {
            throw new \yii\web\NotFoundHttpException('Usuário não encontrado.');
        }

        $model->status = $status;
        if ($model->save()) {
            $statusText = $status == 1 ? 'ativado' : 'desativado';
            Yii::$app->session->setFlash('success', "Usuário {$statusText} com sucesso!");
        } else {
            Yii::$app->session->setFlash('error', 'Erro ao alterar status do usuário.');
        }

        return $this->redirect(['usuarios']);
    }
}
