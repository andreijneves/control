<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use app\models\Empresa;
use app\models\Cliente;
use app\models\Servico;
use app\models\Funcionario;
use app\models\Agendamento;
use app\models\Usuario;

class ClienteController extends Controller
{
    public function beforeAction($action)
    {
        // Desabilitar CSRF para ações públicas
        if (in_array($action->id, ['area-publica', 'empresas', 'cadastro', 'login-cliente'])) {
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
                        'actions' => ['area-publica', 'empresas', 'cadastro', 'login-cliente'],
                        'allow' => true,
                        'roles' => ['?', '@'], // Permite usuários logados e não logados
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function () {
                            return Yii::$app->user->identity->isAdminEmpresa();
                        }
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function () {
                            return Yii::$app->user->identity->isCliente();
                        }
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $user = Yii::$app->user->identity;
        
        // Buscar cliente associado ao usuário
        $cliente = Cliente::findOne(['usuario_id' => $user->id]);
        if (!$cliente) {
            Yii::$app->session->setFlash('error', 'Perfil de cliente não encontrado.');
            return $this->redirect(['empresas']);
        }

        // Cliente pertence a uma empresa específica
        $empresa = $cliente->empresa;
        if (!$empresa) {
            Yii::$app->session->setFlash('error', 'Empresa não encontrada.');
            return $this->redirect(['empresas']);
        }
        
        $servicos = Servico::find()->where(['empresa_id' => $cliente->empresa_id, 'status' => 1])->all();
        $agendamentos = Agendamento::find()->where(['cliente_id' => $cliente->id])->orderBy(['data_agendamento' => SORT_DESC])->all();

        return $this->render('index', [
            'cliente' => $cliente,
            'empresa' => $empresa,
            'servicos' => $servicos,
            'agendamentos' => $agendamentos,
        ]);
    }

    public function actionCadastrar()
    {
        $user = Yii::$app->user->identity;
        
        // Verificar se já tem cadastro
        $cliente = Cliente::findOne(['usuario_id' => $user->id]);
        if ($cliente) {
            return $this->redirect(['index']);
        }

        $model = new Cliente();

        if ($model->load(Yii::$app->request->post())) {
            $model->usuario_id = $user->id;
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Cadastro realizado com sucesso!');
                return $this->redirect(['index']);
            }
        }

        // Se o usuário tem empresa_id, usar essa empresa
        if ($user->empresa_id) {
            $model->empresa_id = $user->empresa_id;
        }

        return $this->render('cadastrar', [
            'model' => $model,
        ]);
    }

    /**
     * Área Pública de uma empresa específica
     */
    public function actionAreaPublica($empresa_id)
    {
        $empresa = Empresa::findOne(['id' => $empresa_id, 'status' => 1]);
        
        if (!$empresa) {
            throw new \yii\web\NotFoundHttpException('Empresa não encontrada.');
        }
        
        $servicos = Servico::find()->where(['empresa_id' => $empresa_id, 'status' => 1])->all();
        $funcionarios = Funcionario::find()->where(['empresa_id' => $empresa_id, 'status' => 1])->all();
        $horarios = \app\models\Horario::find()->where(['empresa_id' => $empresa_id, 'funcionario_id' => null])->all();
        
        // Processar agendamento se for POST
        if (Yii::$app->request->isPost) {
            $cliente_data = Yii::$app->request->post('Cliente', []);
            $agendamento_data = Yii::$app->request->post('Agendamento', []);
            
            $cliente = null;
            
            // Se usuário não está logado, criar conta automática
            if (Yii::$app->user->isGuest && !empty($cliente_data)) {
                $usuario = new Usuario();
                $cliente_obj = new Cliente();
                
                // Criar usuário
                $usuario->username = $cliente_data['email'];
                $usuario->email = $cliente_data['email'];
                $usuario->setPassword($cliente_data['senha']);
                $usuario->generateAuthKey();
                $usuario->role = Usuario::ROLE_CLIENTE;
                $usuario->nome_completo = $cliente_data['nome'];
                $usuario->telefone = $cliente_data['telefone'];
                $usuario->empresa_id = $empresa_id; // Vincular usuário à empresa
                $usuario->status = 1;
                
                if ($usuario->save()) {
                    // Criar cliente
                    $cliente_obj->usuario_id = $usuario->id;
                    $cliente_obj->nome = $cliente_data['nome'];
                    $cliente_obj->email = $cliente_data['email'];
                    $cliente_obj->telefone = $cliente_data['telefone'];
                    $cliente_obj->empresa_id = $empresa_id; // Cliente pertence diretamente à empresa
                    $cliente_obj->status = 1;
                    
                    if ($cliente_obj->save()) {
                        // Login automático
                        Yii::$app->user->login($usuario);
                        $cliente = $cliente_obj;
                    }
                }
            } else if (!Yii::$app->user->isGuest) {
                // Usuário já logado
                $user = Yii::$app->user->identity;
                $cliente = Cliente::findOne(['usuario_id' => $user->id]);
                
                // Verificar se o cliente pertence à empresa
                if ($cliente && $cliente->empresa_id != $empresa_id) {
                    Yii::$app->session->setFlash('error', 'Você só pode agendar serviços na empresa ' . $cliente->empresa->nome);
                    return $this->redirect(['area-publica', 'empresa_id' => $cliente->empresa_id]);
                }
            }
            
            // Criar agendamento
            if ($cliente && !empty($agendamento_data)) {
                $agendamento = new Agendamento();
                $agendamento->cliente_id = $cliente->id;
                $agendamento->empresa_id = $empresa_id;
                $agendamento->servico_id = $agendamento_data['servico_id'];
                $agendamento->funcionario_id = $agendamento_data['funcionario_id'];
                $agendamento->data_agendamento = $agendamento_data['data_agendamento'];
                $agendamento->status = Agendamento::STATUS_PENDENTE;
                
                if ($agendamento->save()) {
                    Yii::$app->session->setFlash('success', 'Agendamento solicitado com sucesso! A empresa entrará em contato para confirmação.');
                    return $this->refresh();
                } else {
                    Yii::$app->session->setFlash('error', 'Erro ao salvar agendamento. Tente novamente.');
                }
            }
        }
        
        return $this->render('area-publica', [
            'empresa' => $empresa,
            'servicos' => $servicos,
            'funcionarios' => $funcionarios,
            'horarios' => $horarios,
        ]);
    }

    /**
     * Lista de empresas (index geral)
     */
    public function actionEmpresas()
    {
        $empresas = Empresa::find()->where(['status' => 1])->all();
        
        return $this->render('empresas', [
            'empresas' => $empresas,
        ]);
    }

    /**
     * Cadastro de cliente (via área pública de uma empresa específica)
     */
    public function actionCadastro($empresa_id)
    {
        $empresa = Empresa::findOne(['id' => $empresa_id, 'status' => 1]);
        
        if (!$empresa) {
            throw new \yii\web\NotFoundHttpException('Empresa não encontrada.');
        }
        
        $usuario = new Usuario();
        $cliente = new Cliente();
        
        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post();
            
            // Criar usuário
            $usuario->username = $data['Cliente']['email'];
            $usuario->email = $data['Cliente']['email'];
            $usuario->setPassword($data['senha']);
            $usuario->generateAuthKey();
            $usuario->role = Usuario::ROLE_CLIENTE;
            $usuario->nome_completo = $data['Cliente']['nome'];
            $usuario->telefone = $data['Cliente']['telefone'];
            $usuario->empresa_id = $empresa_id; // Vincular usuário à empresa
            $usuario->status = 1;
            
            if ($usuario->save()) {
                // Criar cliente
                $cliente->usuario_id = $usuario->id;
                $cliente->nome = $data['Cliente']['nome'];
                $cliente->email = $data['Cliente']['email'];
                $cliente->telefone = $data['Cliente']['telefone'];
                $cliente->cpf = $data['Cliente']['cpf'] ?? null;
                $cliente->endereco = $data['Cliente']['endereco'] ?? null;
                $cliente->empresa_id = $empresa_id; // Cliente pertence diretamente à empresa
                $cliente->status = 1;
                
                if ($cliente->save()) {
                    Yii::$app->session->setFlash('success', 'Cadastro realizado com sucesso na empresa ' . $empresa->nome . '! Você já pode fazer login.');
                    return $this->redirect(['area-publica', 'empresa_id' => $empresa_id]);
                } else {
                    $usuario->delete(); // Desfazer criação do usuário se cliente falhou
                }
            }
        }
        
        return $this->render('cadastro', [
            'usuario' => $usuario,
            'cliente' => $cliente,
            'empresa' => $empresa,
        ]);
    }

    /**
     * Login específico para clientes
     */
    public function actionLoginCliente()
    {
        if (!Yii::$app->user->isGuest) {
            if (Yii::$app->user->identity->isCliente()) {
                return $this->redirect(['index']);
            }
            return $this->goHome();
        }

        $model = new \app\models\LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            // Verificar se é cliente
            if (Yii::$app->user->identity->isCliente()) {
                return $this->redirect(['index']);
            } else {
                Yii::$app->session->setFlash('error', 'Acesso restrito para clientes.');
                Yii::$app->user->logout();
                return $this->refresh();
            }
        }

        $model->password = '';
        return $this->render('login-cliente', [
            'model' => $model,
        ]);
    }
}
