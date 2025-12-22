<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\ActionColumn;

$this->title = 'Gerenciar Usuários';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="usuarios-index">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><?= Html::encode($this->title) ?></h1>
        <?= Html::a('➕ Criar Usuário', ['criar-usuario'], ['class' => 'btn btn-success']) ?>
    </div>

    <div class="card">
        <div class="card-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    [
                        'attribute' => 'id',
                        'headerOptions' => ['style' => 'width: 60px'],
                    ],
                    [
                        'attribute' => 'username',
                        'label' => 'Usuário',
                    ],
                    [
                        'attribute' => 'email',
                        'format' => 'email',
                    ],
                    [
                        'attribute' => 'nome_completo',
                        'label' => 'Nome Completo',
                    ],
                    [
                        'attribute' => 'role',
                        'label' => 'Tipo',
                        'value' => function($model) {
                            $roles = [
                                'admin' => '🔑 Admin Geral',
                                'admin_empresa' => '🏢 Admin Empresa',
                                'funcionario' => '👤 Funcionário',
                                'cliente' => '🛍️ Cliente'
                            ];
                            return $roles[$model->role] ?? $model->role;
                        },
                        'headerOptions' => ['style' => 'width: 150px'],
                    ],
                    [
                        'attribute' => 'empresa_id',
                        'label' => 'Empresa',
                        'value' => function($model) {
                            return $model->empresa ? $model->empresa->nome : '-';
                        },
                    ],
                    [
                        'attribute' => 'status',
                        'format' => 'raw',
                        'value' => function($model) {
                            if ($model->status == 1) {
                                return '<span class="badge bg-success">✅ Ativo</span>';
                            } else {
                                return '<span class="badge bg-danger">❌ Inativo</span>';
                            }
                        },
                        'headerOptions' => ['style' => 'width: 100px'],
                    ],
                    [
                        'attribute' => 'created_at',
                        'label' => 'Criado em',
                        'format' => ['datetime', 'php:d/m/Y H:i'],
                        'headerOptions' => ['style' => 'width: 140px'],
                    ],
                    [
                        'class' => ActionColumn::class,
                        'template' => '{view} {update} {status}',
                        'buttons' => [
                            'view' => function ($url, $model) {
                                return Html::a('👁️', ['editar-usuario', 'id' => $model->id], [
                                    'title' => 'Ver/Editar',
                                    'class' => 'btn btn-sm btn-outline-primary',
                                ]);
                            },
                            'update' => function ($url, $model) {
                                return Html::a('✏️', ['editar-usuario', 'id' => $model->id], [
                                    'title' => 'Editar',
                                    'class' => 'btn btn-sm btn-outline-warning',
                                ]);
                            },
                            'status' => function ($url, $model) {
                                if ($model->role === 'admin') {
                                    return '<span class="text-muted" title="Admin principal não pode ser desativado">🔒</span>';
                                }
                                
                                if ($model->status == 1) {
                                    return Html::a('❌', ['alterar-status-usuario', 'id' => $model->id, 'status' => 0], [
                                        'title' => 'Desativar',
                                        'class' => 'btn btn-sm btn-outline-danger',
                                        'data-confirm' => 'Tem certeza que deseja desativar este usuário?',
                                    ]);
                                } else {
                                    return Html::a('✅', ['alterar-status-usuario', 'id' => $model->id, 'status' => 1], [
                                        'title' => 'Ativar',
                                        'class' => 'btn btn-sm btn-outline-success',
                                    ]);
                                }
                            },
                        ],
                        'headerOptions' => ['style' => 'width: 120px'],
                    ],
                ],
            ]); ?>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card bg-light">
                <div class="card-body">
                    <h6 class="card-title">📋 Tipos de Usuário</h6>
                    <ul class="list-unstyled mb-0">
                        <li><strong>🔑 Admin Geral:</strong> Acesso total ao sistema</li>
                        <li><strong>🏢 Admin Empresa:</strong> Gerencia uma empresa específica</li>
                        <li><strong>👤 Funcionário:</strong> Funcionário de uma empresa</li>
                        <li><strong>🛍️ Cliente:</strong> Cliente de uma empresa</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card bg-light">
                <div class="card-body">
                    <h6 class="card-title">⚠️ Importante</h6>
                    <ul class="list-unstyled mb-0">
                        <li>• Admin principal não pode ser desativado</li>
                        <li>• Usuários inativos não conseguem fazer login</li>
                        <li>• Clientes são criados automaticamente pela área pública</li>
                        <li>• Admin empresa deve estar vinculado a uma empresa</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>