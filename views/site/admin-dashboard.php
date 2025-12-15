<?php

/** @var yii\web\View $this */
/** @var int $totalOrganizations */
/** @var int $totalEmployees */
/** @var int $totalServices */
/** @var app\models\Organization[] $organizations */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Dashboard Administrativo';

$this->registerCss("
.admin-dashboard {
    padding: 2rem 0;
}

.admin-dashboard h1 {
    color: #2d3748;
    font-weight: 700;
    margin-bottom: 0.5rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.admin-dashboard .subtitle {
    color: #718096;
    margin-bottom: 2rem;
    font-size: 1.1rem;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 3rem;
}

.stat-card {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(102, 126, 234, 0.15);
    border-color: #667eea;
}

.stat-card .icon {
    font-size: 3rem;
    margin-bottom: 1rem;
}

.stat-card .number {
    font-size: 2.5rem;
    font-weight: 700;
    color: #667eea;
    margin: 0;
}

.stat-card .label {
    color: #718096;
    font-size: 1rem;
    font-weight: 500;
    margin-top: 0.5rem;
}

.organizations-section {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
}

.organizations-section h2 {
    color: #2d3748;
    font-weight: 600;
    margin-bottom: 1.5rem;
    font-size: 1.5rem;
}

.org-table {
    width: 100%;
    border-collapse: collapse;
}

.org-table thead {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
}

.org-table th {
    padding: 1rem;
    text-align: left;
    font-weight: 600;
    color: #4a5568;
    border-bottom: 2px solid #667eea;
}

.org-table td {
    padding: 1rem;
    border-bottom: 1px solid #e2e8f0;
    color: #4a5568;
}

.org-table tbody tr:hover {
    background: rgba(102, 126, 234, 0.05);
}

.org-table .org-name {
    font-weight: 600;
    color: #2d3748;
}

.org-table .org-cnpj {
    font-family: monospace;
    color: #718096;
}

.org-table .org-date {
    color: #a0aec0;
    font-size: 0.9rem;
}

.btn-view-all {
    display: inline-block;
    margin-top: 1.5rem;
    padding: 0.75rem 2rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    text-decoration: none;
    border-radius: 25px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

.btn-view-all:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
    color: white;
}

.no-data {
    text-align: center;
    padding: 3rem;
    color: #a0aec0;
}

.no-data .icon {
    font-size: 4rem;
    margin-bottom: 1rem;
}

@media (max-width: 768px) {
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .org-table {
        font-size: 0.9rem;
    }
    
    .org-table th,
    .org-table td {
        padding: 0.75rem 0.5rem;
    }
}
");
?>

<div class="admin-dashboard">
    <h1><?= Html::encode($this->title) ?></h1>
    <p class="subtitle">Visão geral do sistema</p>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="icon">🏢</div>
            <div class="number"><?= $totalOrganizations ?></div>
            <div class="label">Organizações</div>
        </div>
        
        <div class="stat-card">
            <div class="icon">👥</div>
            <div class="number"><?= $totalEmployees ?></div>
            <div class="label">Funcionários</div>
        </div>
        
        <div class="stat-card">
            <div class="icon">⚙️</div>
            <div class="number"><?= $totalServices ?></div>
            <div class="label">Serviços</div>
        </div>
    </div>

    <div class="organizations-section">
        <h2>📋 Últimas Organizações Cadastradas</h2>
        
        <?php if (count($organizations) > 0): ?>
            <table class="org-table">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>CNPJ</th>
                        <th>E-mail</th>
                        <th>Telefone</th>
                        <th>Cadastrado em</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($organizations as $org): ?>
                        <tr>
                            <td class="org-name"><?= Html::encode($org->name) ?></td>
                            <td class="org-cnpj"><?= Html::encode($org->cnpj ?: '-') ?></td>
                            <td><?= Html::encode($org->email ?: '-') ?></td>
                            <td><?= Html::encode($org->phone ?: '-') ?></td>
                            <td class="org-date"><?= Yii::$app->formatter->asDatetime($org->created_at, 'php:d/m/Y H:i') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
            <?= Html::a('Ver Todas as Organizações', ['/admin/organization/index'], ['class' => 'btn-view-all']) ?>
        <?php else: ?>
            <div class="no-data">
                <div class="icon">📭</div>
                <p>Nenhuma organização cadastrada ainda.</p>
            </div>
        <?php endif; ?>
    </div>
</div>
