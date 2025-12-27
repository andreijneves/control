<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use app\models\ContactForm;

$this->title = 'Contato - Control';
$this->params['breadcrumbs'][] = $this->title;
?>

<!-- Hero Section da página Contato -->
<div class="hero-section" style="min-height: 40vh;">
    <div class="container">
        <div class="hero-content">
            <h1 class="display-4">📞 Fale Conosco</h1>
            <p class="lead">Estamos aqui para ajudar você</p>
        </div>
    </div>
</div>

<div class="container my-5">
    <div class="row">
        <!-- Informações de Contato -->
        <div class="col-lg-4 mb-4">
            <div class="feature-card h-100">
                <div class="feature-icon">📧</div>
                <h5>Email</h5>
                <p>contato@control.com.br</p>
                <p class="text-muted">Resposta em até 24h</p>
            </div>
        </div>
        
        <div class="col-lg-4 mb-4">
            <div class="feature-card h-100">
                <div class="feature-icon">📱</div>
                <h5>WhatsApp</h5>
                <p>(11) 99999-9999</p>
                <p class="text-muted">Atendimento das 8h às 18h</p>
            </div>
        </div>
        
        <div class="col-lg-4 mb-4">
            <div class="feature-card h-100">
                <div class="feature-icon">💬</div>
                <h5>Chat Online</h5>
                <p>Suporte imediato</p>
                <p class="text-muted">Segunda a Sexta, 8h-18h</p>
            </div>
        </div>
    </div>

    <!-- Formulário de Contato -->
    <div class="row justify-content-center mt-5">
        <div class="col-lg-8">
            <div class="feature-card">
                <div class="text-center mb-4">
                    <div class="feature-icon">✉️</div>
                    <h3>Envie uma Mensagem</h3>
                    <p class="text-muted">Ficaremos felizes em responder suas dúvidas</p>
                </div>
                
                <?php $form = ActiveForm::begin([
                    'id' => 'contact-form',
                    'options' => ['class' => 'row g-3']
                ]); ?>

                    <div class="col-md-6">
                        <?= $form->field($model, 'nome')->textInput([
                            'placeholder' => 'Seu nome completo'
                        ]) ?>
                    </div>

                    <div class="col-md-6">
                        <?= $form->field($model, 'email')->textInput([
                            'placeholder' => 'seu@email.com'
                        ]) ?>
                    </div>

                    <div class="col-12">
                        <?= $form->field($model, 'assunto')->textInput([
                            'placeholder' => 'Assunto da sua mensagem'
                        ]) ?>
                    </div>

                    <div class="col-12">
                        <?= $form->field($model, 'mensagem')->textarea([
                            'rows' => 6,
                            'placeholder' => 'Digite sua mensagem aqui...'
                        ]) ?>
                    </div>

                    <div class="col-12 text-center">
                        <?= Html::submitButton('<span>🚀 Enviar Mensagem</span>', [
                            'class' => 'btn btn-primary-modern btn-modern btn-lg'
                        ]) ?>
                    </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>

    <!-- FAQ Rápido -->
    <div class="mt-5">
        <h3 class="text-center text-white mb-4">🤔 Dúvidas Frequentes</h3>
        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="feature-card h-100">
                    <h6><strong>❓ Como começar a usar o Control?</strong></h6>
                    <p class="mb-0">Cadastre sua empresa gratuitamente e comece a agendar imediatamente!</p>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="feature-card h-100">
                    <h6><strong>💰 Quanto custa?</strong></h6>
                    <p class="mb-0">O Control tem planos acessíveis para todos os tamanhos de negócio.</p>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="feature-card h-100">
                    <h6><strong>📱 Funciona no celular?</strong></h6>
                    <p class="mb-0">Sim! Totalmente responsivo e otimizado para dispositivos móveis.</p>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="feature-card h-100">
                    <h6><strong>🔧 Preciso de treinamento?</strong></h6>
                    <p class="mb-0">Nosso sistema é intuitivo, mas oferecemos suporte completo!</p>
                </div>
            </div>
        </div>
    </div>
</div>
