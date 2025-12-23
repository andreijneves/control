<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use app\models\Servico;
use app\models\Funcionario;
use app\models\Cliente;
use app\models\Agendamento;
use app\models\Horario;

class EmpresaController extends Controller
{
    public function beforeAction($action)
    {
        // Desabilitar CSRF para ações de agendamento que usam data-method="post"
        if (in_array($action->id, ['confirmar-agendamento', 'cancelar-agendamento'])) {
            $this->enableCsrfValidation = false;
        }
        
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
                            $user = Yii::$app->user->identity;
                            return $user->isAdminEmpresa() && $user->empresa_id;
                        }
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $empresa_id = Yii::$app->user->identity->empresa_id;
        
        // Verificar se foi passada uma semana específica via GET
        $semanaParam = Yii::$app->request->get('week');
        if ($semanaParam) {
            $inicioSemana = date('Y-m-d', strtotime('monday', strtotime($semanaParam)));
        } else {
            $inicioSemana = date('Y-m-d', strtotime('monday this week'));
        }
        $fimSemana = date('Y-m-d', strtotime('sunday', strtotime($inicioSemana)));
        
        $agendamentosSemana = Agendamento::find()
            ->where(['empresa_id' => $empresa_id, 'status' => Agendamento::STATUS_CONFIRMADO])
            ->andWhere(['between', 'DATE(data_agendamento)', $inicioSemana, $fimSemana])
            ->with(['cliente', 'funcionario', 'servico'])
            ->orderBy('data_agendamento ASC')
            ->all();

        return $this->render('index', [
            'empresa_id' => $empresa_id,
            'totalServicos' => Servico::find()->where(['empresa_id' => $empresa_id])->count(),
            'totalFuncionarios' => Funcionario::find()->where(['empresa_id' => $empresa_id])->count(),
            'totalClientes' => Cliente::find()->where(['empresa_id' => $empresa_id])->count(),
            'totalAgendamentos' => Agendamento::find()->where(['empresa_id' => $empresa_id])->count(),
            'agendamentosSemana' => $agendamentosSemana,
            'inicioSemana' => $inicioSemana,
            'fimSemana' => $fimSemana,
        ]);
    }
    
    public function actionCalendarioSemanal($week = null)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $empresa_id = Yii::$app->user->identity->empresa_id;
        
        if ($week) {
            $inicioSemana = date('Y-m-d', strtotime($week));
        } else {
            $inicioSemana = date('Y-m-d', strtotime('monday this week'));
        }
        
        $fimSemana = date('Y-m-d', strtotime($inicioSemana . ' +6 days'));
        
        $agendamentos = Agendamento::find()
            ->where(['empresa_id' => $empresa_id, 'status' => Agendamento::STATUS_CONFIRMADO])
            ->andWhere(['between', 'DATE(data_agendamento)', $inicioSemana, $fimSemana])
            ->with(['cliente', 'funcionario', 'servico'])
            ->orderBy('data_agendamento ASC')
            ->all();
            
        $eventos = [];
        foreach ($agendamentos as $agendamento) {
            $eventos[] = [
                'id' => $agendamento->id,
                'title' => $agendamento->cliente->nome . ' - ' . $agendamento->servico->nome,
                'start' => $agendamento->data_agendamento,
                'funcionario' => $agendamento->funcionario->nome,
                'cliente' => $agendamento->cliente->nome,
                'servico' => $agendamento->servico->nome,
                'observacoes' => $agendamento->observacoes,
            ];
        }
        
        return [
            'eventos' => $eventos,
            'inicioSemana' => $inicioSemana,
            'fimSemana' => $fimSemana,
        ];
    }

    // SERVIÇOS
    public function actionServicos()
    {
        $empresa_id = Yii::$app->user->identity->empresa_id;
        $dataProvider = new ActiveDataProvider([
            'query' => Servico::find()->where(['empresa_id' => $empresa_id]),
            'pagination' => ['pageSize' => 20],
        ]);

        return $this->render('servicos', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCriarServico()
    {
        $model = new Servico();
        $model->empresa_id = Yii::$app->user->identity->empresa_id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Serviço criado com sucesso!');
            return $this->redirect(['servicos']);
        }

        return $this->render('criar-servico', [
            'model' => $model,
        ]);
    }

    public function actionEditarServico($id)
    {
        $model = Servico::findOne($id);
        $this->verificarEmpresa($model->empresa_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Serviço atualizado com sucesso!');
            return $this->redirect(['servicos']);
        }

        return $this->render('editar-servico', [
            'model' => $model,
        ]);
    }

    public function actionDeletarServico($id)
    {
        $model = Servico::findOne($id);
        $this->verificarEmpresa($model->empresa_id);
        $model->delete();
        Yii::$app->session->setFlash('success', 'Serviço deletado com sucesso!');
        return $this->redirect(['servicos']);
    }

    // FUNCIONÁRIOS
    public function actionFuncionarios()
    {
        $empresa_id = Yii::$app->user->identity->empresa_id;
        $dataProvider = new ActiveDataProvider([
            'query' => Funcionario::find()->where(['empresa_id' => $empresa_id]),
            'pagination' => ['pageSize' => 20],
        ]);

        return $this->render('funcionarios', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCriarFuncionario()
    {
        $model = new Funcionario();
        $model->empresa_id = Yii::$app->user->identity->empresa_id;

        if ($model->load(Yii::$app->request->post())) {
            $usuario = new \app\models\Usuario();
            $usuario->username = $model->nome . '_func_' . time();
            $usuario->email = $model->email;
            $usuario->setPassword(Yii::$app->request->post('senha'));
            $usuario->generateAuthKey();
            $usuario->role = \app\models\Usuario::ROLE_FUNCIONARIO;
            $usuario->empresa_id = $model->empresa_id;
            $usuario->nome_completo = $model->nome;
            $usuario->status = 1;

            if ($usuario->save()) {
                $model->usuario_id = $usuario->id;
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'Funcionário criado com sucesso!');
                    return $this->redirect(['funcionarios']);
                }
            }
        }

        return $this->render('criar-funcionario', [
            'model' => $model,
        ]);
    }

    public function actionEditarFuncionario($id)
    {
        $model = Funcionario::findOne($id);
        $this->verificarEmpresa($model->empresa_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Funcionário atualizado com sucesso!');
            return $this->redirect(['funcionarios']);
        }

        return $this->render('editar-funcionario', [
            'model' => $model,
        ]);
    }

    public function actionConfigurarHorarios($funcionario_id = null)
    {
        // Se não especificou funcionário_id, mostra lista de funcionários
        if ($funcionario_id === null) {
            $empresa_id = Yii::$app->user->identity->empresa_id;
            $funcionarios = Funcionario::find()->where(['empresa_id' => $empresa_id])->all();

            return $this->render('listar-funcionarios-horarios', [
                'funcionarios' => $funcionarios,
            ]);
        }

        $funcionario = Funcionario::findOne($funcionario_id);
        if (!$funcionario) {
            throw new \yii\web\NotFoundHttpException('Funcionário não encontrado.');
        }
        $this->verificarEmpresa($funcionario->empresa_id);

        $horarios = Horario::find()->where(['funcionario_id' => $funcionario_id])->all();

        if (Yii::$app->request->isPost) {
            $horarios_post = Yii::$app->request->post('horarios', []);
            
            // Deletar horários existentes
            Horario::deleteAll(['funcionario_id' => $funcionario_id]);

            // Criar novos horários
            foreach ($horarios_post as $dia => $dados) {
                if (!empty($dados['hora_inicio']) && !empty($dados['hora_fim'])) {
                    $horario = new Horario();
                    $horario->funcionario_id = $funcionario_id;
                    $horario->empresa_id = $funcionario->empresa_id;
                    $horario->dia_semana = $dia;
                    $horario->hora_inicio = $dados['hora_inicio'];
                    $horario->hora_fim = $dados['hora_fim'];
                    $horario->disponivel = isset($dados['disponivel']) ? 1 : 0;
                    $horario->save();
                }
            }

            Yii::$app->session->setFlash('success', 'Horários configurados com sucesso!');
            return $this->redirect(['configurar-horarios']);
        }

        return $this->render('configurar-horarios', [
            'funcionario' => $funcionario,
            'horarios' => $horarios,
        ]);
    }

    // CLIENTES
    public function actionClientes()
    {
        $empresa_id = Yii::$app->user->identity->empresa_id;
        $dataProvider = new ActiveDataProvider([
            'query' => Cliente::find()->where(['empresa_id' => $empresa_id]),
            'pagination' => ['pageSize' => 20],
        ]);

        return $this->render('clientes', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCriarCliente()
    {
        $model = new Cliente();
        $model->empresa_id = Yii::$app->user->identity->empresa_id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Cliente criado com sucesso!');
            return $this->redirect(['clientes']);
        }

        return $this->render('criar-cliente', [
            'model' => $model,
        ]);
    }

    public function actionEditarCliente($id)
    {
        $model = Cliente::findOne($id);
        $this->verificarEmpresa($model->empresa_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Cliente atualizado com sucesso!');
            return $this->redirect(['clientes']);
        }

        return $this->render('editar-cliente', [
            'model' => $model,
        ]);
    }

    // AGENDAMENTOS
    public function actionAgendamentos()
    {
        $empresa_id = Yii::$app->user->identity->empresa_id;
        $tipoView = Yii::$app->request->get('view', 'calendario'); // padrão: calendário
        
        if ($tipoView === 'lista') {
            // Visualização em lista (GridView original)
            $dataProvider = new ActiveDataProvider([
                'query' => Agendamento::find()->where(['empresa_id' => $empresa_id])->with(['cliente', 'funcionario', 'servico']),
                'pagination' => ['pageSize' => 20],
                'sort' => [
                    'defaultOrder' => ['data_agendamento' => SORT_DESC]
                ]
            ]);

            return $this->render('agendamentos', [
                'dataProvider' => $dataProvider,
                'tipoView' => $tipoView,
            ]);
        } else {
            // Visualização em calendário
            // Verificar se foi passada uma semana específica via GET
            $semanaParam = Yii::$app->request->get('week');
            if ($semanaParam) {
                $inicioSemana = date('Y-m-d', strtotime('monday', strtotime($semanaParam)));
            } else {
                $inicioSemana = date('Y-m-d', strtotime('monday this week'));
            }
            $fimSemana = date('Y-m-d', strtotime('sunday', strtotime($inicioSemana)));
            
            // Buscar TODOS os agendamentos da semana (não apenas confirmados)
            $agendamentosSemana = Agendamento::find()
                ->where(['empresa_id' => $empresa_id])
                ->andWhere(['between', 'DATE(data_agendamento)', $inicioSemana, $fimSemana])
                ->with(['cliente', 'funcionario', 'servico'])
                ->orderBy('data_agendamento ASC')
                ->all();
                
            // Estatísticas da semana
            $estatisticas = [
                'pendentes' => 0,
                'confirmados' => 0,
                'cancelados' => 0,
                'concluidos' => 0,
            ];
            
            foreach ($agendamentosSemana as $agendamento) {
                switch($agendamento->status) {
                    case Agendamento::STATUS_PENDENTE:
                        $estatisticas['pendentes']++;
                        break;
                    case Agendamento::STATUS_CONFIRMADO:
                        $estatisticas['confirmados']++;
                        break;
                    case Agendamento::STATUS_CANCELADO:
                        $estatisticas['cancelados']++;
                        break;
                    case Agendamento::STATUS_CONCLUIDO:
                        $estatisticas['concluidos']++;
                        break;
                }
            }

            return $this->render('agendamentos', [
                'agendamentosSemana' => $agendamentosSemana,
                'inicioSemana' => $inicioSemana,
                'fimSemana' => $fimSemana,
                'estatisticas' => $estatisticas,
                'tipoView' => $tipoView,
            ]);
        }
    }

    public function actionConfirmarAgendamento($id)
    {
        $model = Agendamento::findOne($id);
        $this->verificarEmpresa($model->empresa_id);

        if (Yii::$app->request->isPost) {
            $model->status = Agendamento::STATUS_CONFIRMADO;
            $model->save();
            Yii::$app->session->setFlash('success', 'Agendamento confirmado!');
        }

        // Preservar parâmetros de navegação
        $week = Yii::$app->request->get('week');
        $view = Yii::$app->request->get('view', 'calendario');
        $params = ['agendamentos', 'view' => $view];
        if ($week && $view === 'calendario') {
            $params['week'] = $week;
        }
        
        return $this->redirect($params);
    }

    public function actionCancelarAgendamento($id)
    {
        $model = Agendamento::findOne($id);
        $this->verificarEmpresa($model->empresa_id);

        $model->status = Agendamento::STATUS_CANCELADO;
        $model->save();
        Yii::$app->session->setFlash('success', 'Agendamento cancelado!');
        
        // Preservar parâmetros de navegação
        $week = Yii::$app->request->get('week');
        $view = Yii::$app->request->get('view', 'calendario');
        $params = ['agendamentos', 'view' => $view];
        if ($week && $view === 'calendario') {
            $params['week'] = $week;
        }
        
        return $this->redirect($params);
    }

    /**
     * Página de configurações da empresa
     */
    public function actionConfiguracoes()
    {
        $empresa_id = Yii::$app->user->identity->empresa_id;
        $empresa = \app\models\Empresa::findOne($empresa_id);

        if (!$empresa) {
            throw new \yii\web\NotFoundHttpException('Empresa não encontrada.');
        }

        if ($empresa->load(Yii::$app->request->post()) && $empresa->save()) {
            Yii::$app->session->setFlash('success', 'Configurações atualizadas com sucesso!');
            return $this->refresh();
        }

        return $this->render('configuracoes', [
            'empresa' => $empresa,
        ]);
    }

    /**
     * Configurar Horários da Empresa
     */
    public function actionHorarioEmpresa()
    {
        $empresa_id = Yii::$app->user->identity->empresa_id;
        $empresa = \app\models\Empresa::findOne($empresa_id);

        if (!$empresa) {
            throw new \yii\web\NotFoundHttpException('Empresa não encontrada.');
        }

        // Buscar horários da empresa
        $horarios = Horario::find()->where(['empresa_id' => $empresa_id])->andWhere(['IS', 'funcionario_id', null])->all();

        if (Yii::$app->request->isPost) {
            $horarios_post = Yii::$app->request->post('horarios', []);
            
            // Deletar horários existentes da empresa
            Horario::deleteAll(['empresa_id' => $empresa_id, 'funcionario_id' => null]);

            $sucessoSalvamento = true;
            $erros = [];

            // Criar novos horários
            foreach ($horarios_post as $dia => $dados) {
                if (!empty($dados['hora_inicio']) && !empty($dados['hora_fim'])) {
                    $horario = new Horario();
                    $horario->funcionario_id = null; // Horário da empresa, não de funcionário
                    $horario->empresa_id = $empresa_id;
                    $horario->dia_semana = (int)$dia;
                    $horario->dia_semana_texto = $this->getDiaSemana($dia);
                    $horario->hora_inicio = $dados['hora_inicio'] . ':00';
                    $horario->hora_fim = $dados['hora_fim'] . ':00';
                    $horario->disponivel = isset($dados['disponivel']) ? 1 : 0;
                    
                    if (!$horario->save()) {
                        $sucessoSalvamento = false;
                        $erros[] = 'Erro ao salvar horário para ' . $this->getDiaSemana($dia) . ': ' . implode(', ', $horario->getFirstErrors());
                    }
                }
            }

            if ($sucessoSalvamento) {
                Yii::$app->session->setFlash('success', 'Horários da empresa configurados com sucesso!');
                return $this->refresh();
            } else {
                Yii::$app->session->setFlash('error', 'Erro ao salvar horários: ' . implode('<br>', $erros));
            }
        }

        return $this->render('horario-empresa', [
            'empresa' => $empresa,
            'horarios' => $horarios,
        ]);
    }

    private function getDiaSemana($numero)
    {
        $dias = [
            0 => 'Domingo',
            1 => 'Segunda-feira',
            2 => 'Terça-feira',
            3 => 'Quarta-feira',
            4 => 'Quinta-feira',
            5 => 'Sexta-feira',
            6 => 'Sábado',
        ];
        return $dias[$numero] ?? '';
    }

    private function verificarEmpresa($empresa_id)
    {
        if ($empresa_id != Yii::$app->user->identity->empresa_id) {
            throw new \yii\web\ForbiddenHttpException('Você não tem permissão para acessar este recurso.');
        }
    }
}
