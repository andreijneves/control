<?php

use yii\db\Migration;

/**
 * Migration com dados iniciais do sistema
 * Criada em 21/12/2025 - Dados de exemplo e configuração inicial
 */
class m251221_000002_insert_initial_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // ===== USUÁRIO ADMIN GERAL =====
        $adminPasswordHash = Yii::$app->security->generatePasswordHash('admin123');
        $adminAuthKey = Yii::$app->security->generateRandomString();

        $this->update('{{%usuario}}', [
            'password_hash' => $adminPasswordHash,
            'auth_key' => $adminAuthKey,
        ], ['username' => 'admin']);

        // ===== EMPRESA DE EXEMPLO =====
        $this->insert('{{%empresa}}', [
            'nome' => 'Salão Beleza Total',
            'cnpj' => '12.345.678/0001-90',
            'email' => 'contato@belezatotal.com',
            'telefone' => '(11) 99999-9999',
            'endereco' => 'Rua das Flores, 123 - Centro - São Paulo/SP',
            'responsavel' => 'Maria Silva',
            'status' => 1,
        ]);

        $empresaId = $this->db->lastInsertID;

        // ===== USUÁRIO ADMIN DA EMPRESA =====
        $empresaAdminPasswordHash = Yii::$app->security->generatePasswordHash('123456');
        $empresaAdminAuthKey = Yii::$app->security->generateRandomString();

        $this->insert('{{%usuario}}', [
            'username' => 'salao-beleza-total_admin',
            'nome_completo' => 'Maria Silva',
            'email' => 'contato@belezatotal.com',
            'password_hash' => $empresaAdminPasswordHash,
            'auth_key' => $empresaAdminAuthKey,
            'role' => 'admin_empresa',
            'empresa_id' => $empresaId,
            'status' => 1,
        ]);

        // ===== FUNCIONÁRIOS =====
        $this->batchInsert('{{%funcionario}}', 
            ['nome', 'email', 'telefone', 'empresa_id', 'especialidades', 'status'], 
            [
                ['Ana Costa', 'ana@belezatotal.com', '(11) 88888-1111', $empresaId, 'Corte feminino, Coloração, Hidratação', 1],
                ['Carlos Souza', 'carlos@belezatotal.com', '(11) 88888-2222', $empresaId, 'Corte masculino, Barba, Bigode', 1],
                ['Juliana Santos', 'juliana@belezatotal.com', '(11) 88888-3333', $empresaId, 'Manicure, Pedicure, Esmaltação', 1],
            ]
        );

        // ===== SERVIÇOS =====
        $this->batchInsert('{{%servico}}', 
            ['nome', 'descricao', 'preco', 'duracao', 'empresa_id', 'status'], 
            [
                ['Corte Feminino', 'Corte de cabelo feminino com lavagem e secagem', 45.00, 60, $empresaId, 1],
                ['Corte Masculino', 'Corte de cabelo masculino tradicional', 25.00, 30, $empresaId, 1],
                ['Coloração Completa', 'Pintura completa do cabelo com produtos de qualidade', 120.00, 120, $empresaId, 1],
                ['Hidratação Capilar', 'Tratamento hidratante profundo para cabelos', 60.00, 90, $empresaId, 1],
                ['Manicure', 'Cuidados com unhas das mãos e esmaltação', 20.00, 45, $empresaId, 1],
                ['Pedicure', 'Cuidados com unhas dos pés e esmaltação', 25.00, 60, $empresaId, 1],
                ['Barba Completa', 'Aparar barba com navalha e cuidados especiais', 15.00, 30, $empresaId, 1],
            ]
        );

        // ===== HORÁRIOS DE FUNCIONAMENTO =====
        $funcionarios = $this->db->createCommand('SELECT id FROM {{%funcionario}} WHERE empresa_id = :empresa_id')
                              ->bindValue(':empresa_id', $empresaId)
                              ->queryColumn();

        // Horários gerais da empresa (Segunda a Sexta)
        for ($dia = 1; $dia <= 5; $dia++) {
            $this->insert('{{%horario}}', [
                'funcionario_id' => null, // Horário geral
                'empresa_id' => $empresaId,
                'dia_semana' => $dia,
                'hora_inicio' => '08:00:00',
                'hora_fim' => '18:00:00',
                'disponivel' => 1,
            ]);
        }

        // Sábado meio período
        $this->insert('{{%horario}}', [
            'funcionario_id' => null,
            'empresa_id' => $empresaId,
            'dia_semana' => 6, // Sábado
            'hora_inicio' => '08:00:00',
            'hora_fim' => '14:00:00',
            'disponivel' => 1,
        ]);

        // Horários específicos dos funcionários (exemplo)
        foreach ($funcionarios as $funcionarioId) {
            for ($dia = 1; $dia <= 6; $dia++) {
                $horaFim = ($dia == 6) ? '14:00:00' : '18:00:00';
                
                $this->insert('{{%horario}}', [
                    'funcionario_id' => $funcionarioId,
                    'empresa_id' => $empresaId,
                    'dia_semana' => $dia,
                    'hora_inicio' => '08:00:00',
                    'hora_fim' => $horaFim,
                    'disponivel' => 1,
                ]);
            }
        }

        // ===== CLIENTES DE EXEMPLO =====
        $this->batchInsert('{{%cliente}}', 
            ['nome', 'email', 'telefone', 'empresa_id', 'observacoes', 'status'], 
            [
                ['João Silva', 'joao.silva@email.com', '(11) 77777-1111', $empresaId, 'Cliente VIP, prefere atendimento pela manhã', 1],
                ['Maria Oliveira', 'maria.oliveira@email.com', '(11) 77777-2222', $empresaId, 'Alérgica a produtos com amônia', 1],
                ['Pedro Santos', 'pedro.santos@email.com', '(11) 77777-3333', $empresaId, 'Gosta de corte clássico', 1],
                ['Ana Costa', 'ana.costa@email.com', '(11) 77777-4444', $empresaId, null, 1],
                ['Carlos Ferreira', 'carlos.ferreira@email.com', '(11) 77777-5555', $empresaId, 'Cliente desde 2020', 1],
            ]
        );

        // ===== AGENDAMENTOS DE EXEMPLO =====
        $clientes = $this->db->createCommand('SELECT id FROM {{%cliente}} WHERE empresa_id = :empresa_id LIMIT 3')
                           ->bindValue(':empresa_id', $empresaId)
                           ->queryColumn();
                           
        $servicos = $this->db->createCommand('SELECT id FROM {{%servico}} WHERE empresa_id = :empresa_id LIMIT 3')
                           ->bindValue(':empresa_id', $empresaId)
                           ->queryColumn();

        if (!empty($clientes) && !empty($servicos) && !empty($funcionarios)) {
            $this->batchInsert('{{%agendamento}}', 
                ['cliente_id', 'funcionario_id', 'servico_id', 'empresa_id', 'data_agendamento', 'status', 'observacoes'], 
                [
                    [$clientes[0], $funcionarios[0], $servicos[0], $empresaId, date('Y-m-d H:i:s', strtotime('+1 day 10:00')), 'pendente', 'Primeiro agendamento'],
                    [$clientes[1], $funcionarios[1], $servicos[1], $empresaId, date('Y-m-d H:i:s', strtotime('+2 days 14:00')), 'confirmado', null],
                    [$clientes[2], $funcionarios[0], $servicos[2], $empresaId, date('Y-m-d H:i:s', strtotime('+3 days 09:00')), 'pendente', 'Cliente preferencial'],
                ]
            );
        }

        echo "Dados iniciais inseridos com sucesso!\n";
        echo "- Usuário admin: admin / admin123\n";
        echo "- Empresa exemplo: Salão Beleza Total\n";
        echo "- Admin empresa: salao-beleza-total_admin / 123456\n";
        echo "- 3 funcionários, 7 serviços, 5 clientes criados\n";
        echo "- Horários de funcionamento configurados\n";
        echo "- 3 agendamentos de exemplo criados\n";
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Limpar dados em ordem reversa das dependências
        $this->delete('{{%agendamento}}');
        $this->delete('{{%horario}}');
        $this->delete('{{%cliente}}');
        $this->delete('{{%servico}}');
        $this->delete('{{%funcionario}}');
        $this->delete('{{%usuario}}', ['role' => ['admin_empresa', 'funcionario', 'cliente']]);
        $this->delete('{{%empresa}}');

        echo "Dados de exemplo removidos!\n";
    }
}