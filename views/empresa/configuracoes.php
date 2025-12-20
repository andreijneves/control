<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Configurações da Empresa';
$this->params['breadcrumbs'][] = ['label' => 'Dashboard', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="configuracoes-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-8">
            <!-- Formulário de Configurações -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">⚙️ Configurações da Empresa</h5>
                </div>
                <div class="card-body">
                    <?php $form = ActiveForm::begin(); ?>

                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($empresa, 'nome')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($empresa, 'cnpj')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($empresa, 'email')->textInput(['type' => 'email', 'maxlength' => true]) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($empresa, 'telefone')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($empresa, 'cidade')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>

                    <?= $form->field($empresa, 'endereco')->textarea(['rows' => 3]) ?>

                    <?= $form->field($empresa, 'descricao')->textarea(['rows' => 4, 'placeholder' => 'Descreva sua empresa...']) ?>

                    <div class="form-group">
                        <?= Html::submitButton('Salvar Configurações', ['class' => 'btn btn-primary']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>

        <!-- Sidebar com Links Rápidos -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">📋 Outras Configurações</h5>
                </div>
                <div class="list-group list-group-flush">
                    <a href="<?= \yii\helpers\Url::to(['/empresa/configurar-horarios']) ?>" class="list-group-item list-group-item-action">
                        <h6 class="mb-1">🕐 Horários de Funcionamento</h6>
                        <p class="mb-0 small text-muted">Configure os horários da empresa por dia da semana</p>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action disabled">
                        <h6 class="mb-1">🎨 Aparência</h6>
                        <p class="mb-0 small text-muted">Personalize cores e logo (em breve)</p>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action disabled">
                        <h6 class="mb-1">📧 Notificações</h6>
                        <p class="mb-0 small text-muted">Configurar notificações por email (em breve)</p>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action disabled">
                        <h6 class="mb-1">💳 Pagamentos</h6>
                        <p class="mb-0 small text-muted">Integração com sistemas de pagamento (em breve)</p>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action disabled">
                        <h6 class="mb-1">📊 Relatórios</h6>
                        <p class="mb-0 small text-muted">Gerar relatórios de agendamentos (em breve)</p>
                    </a>
                </div>
            </div>

            <!-- Informações Úteis -->
            <div class="card mt-4">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">ℹ️ Informações</h5>
                </div>
                <div class="card-body">
                    <p><strong>Empresa ID:</strong> <?= $empresa->id ?></p>
                    <p><strong>Criada em:</strong> <?= date('d/m/Y H:i', strtotime($empresa->created_at)) ?></p>
                    <p><strong>Última atualização:</strong> <?= date('d/m/Y H:i', strtotime($empresa->updated_at)) ?></p>
                    <hr>
                    <div class="alert alert-info mb-0">
                        <small>
                            Sua empresa está <strong><?= $empresa->status ? 'ativa' : 'inativa' ?></strong>.
                            Clientes podem agendar serviços normalmente.
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
