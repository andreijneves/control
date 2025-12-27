<?php

use yii\db\Migration;

/**
 * Migration completa do sistema de controle de agendamentos
 * Criada em 21/12/2025 - Estado final do sistema
 */
class m251221_000001_create_complete_system_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // 1. Tabela de Empresas (clientes do sistema)
        $this->createTable('{{%empresa}}', [
            'id' => $this->primaryKey(),
            'nome' => $this->string(100)->notNull()->comment('Nome da empresa'),
            'cnpj' => $this->string(18)->unique()->comment('CNPJ da empresa'),
            'email' => $this->string(100)->notNull()->comment('Email principal da empresa'),
            'telefone' => $this->string(20)->comment('Telefone da empresa'),
            'endereco' => $this->text()->comment('Endereço completo da empresa'),
            'responsavel' => $this->string(100)->comment('Nome do responsável'),
            'status' => $this->tinyInteger(1)->defaultValue(1)->comment('1=Ativo, 0=Inativo'),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ], 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB COMMENT="Empresas cadastradas no sistema"');

        // 2. Tabela de Usuários (admins, admins de empresa, funcionários, clientes)
        $this->createTable('{{%usuario}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(50)->notNull()->unique()->comment('Nome de usuário único'),
            'nome_completo' => $this->string(100)->notNull()->comment('Nome completo do usuário'),
            'email' => $this->string(100)->notNull()->comment('Email do usuário'),
            'password_hash' => $this->string(255)->notNull()->comment('Hash da senha'),
            'auth_key' => $this->string(32)->notNull()->comment('Chave de autenticação'),
            'role' => $this->string(20)->notNull()->comment('admin, admin_empresa, funcionario, cliente'),
            'empresa_id' => $this->integer()->comment('ID da empresa (null para admin geral)'),
            'status' => $this->tinyInteger(1)->defaultValue(1)->comment('1=Ativo, 0=Inativo'),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ], 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB COMMENT="Usuários do sistema com diferentes roles"');

        // 3. Tabela de Funcionários (da empresa)
        $this->createTable('{{%funcionario}}', [
            'id' => $this->primaryKey(),
            'nome' => $this->string(100)->notNull()->comment('Nome do funcionário'),
            'email' => $this->string(100)->comment('Email do funcionário'),
            'telefone' => $this->string(20)->comment('Telefone do funcionário'),
            'empresa_id' => $this->integer()->notNull()->comment('ID da empresa'),
            'especialidades' => $this->text()->comment('Especialidades do funcionário'),
            'status' => $this->tinyInteger(1)->defaultValue(1)->comment('1=Ativo, 0=Inativo'),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ], 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB COMMENT="Funcionários das empresas"');

        // 4. Tabela de Serviços (oferecidos pela empresa)
        $this->createTable('{{%servico}}', [
            'id' => $this->primaryKey(),
            'nome' => $this->string(100)->notNull()->comment('Nome do serviço'),
            'descricao' => $this->text()->comment('Descrição detalhada do serviço'),
            'preco' => $this->decimal(10, 2)->comment('Preço do serviço'),
            'duracao' => $this->integer()->comment('Duração em minutos'),
            'empresa_id' => $this->integer()->notNull()->comment('ID da empresa'),
            'status' => $this->tinyInteger(1)->defaultValue(1)->comment('1=Ativo, 0=Inativo'),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ], 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB COMMENT="Serviços oferecidos pelas empresas"');

        // 5. Tabela de Clientes (da empresa)
        $this->createTable('{{%cliente}}', [
            'id' => $this->primaryKey(),
            'nome' => $this->string(100)->notNull()->comment('Nome do cliente'),
            'email' => $this->string(100)->notNull()->comment('Email do cliente'),
            'telefone' => $this->string(20)->comment('Telefone do cliente'),
            'empresa_id' => $this->integer()->notNull()->comment('ID da empresa'),
            'observacoes' => $this->text()->comment('Observações sobre o cliente'),
            'status' => $this->tinyInteger(1)->defaultValue(1)->comment('1=Ativo, 0=Inativo'),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ], 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB COMMENT="Clientes das empresas"');

        // 6. Tabela de Horários de Funcionamento
        $this->createTable('{{%horario}}', [
            'id' => $this->primaryKey(),
            'funcionario_id' => $this->integer()->comment('ID do funcionário (nullable para horários gerais)'),
            'empresa_id' => $this->integer()->notNull()->comment('ID da empresa'),
            'dia_semana' => $this->tinyInteger()->notNull()->comment('0=Domingo, 1=Segunda, ... 6=Sábado'),
            'hora_inicio' => $this->time()->notNull()->comment('Hora de início'),
            'hora_fim' => $this->time()->notNull()->comment('Hora de fim'),
            'disponivel' => $this->tinyInteger(1)->defaultValue(1)->comment('1=Disponível, 0=Indisponível'),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ], 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB COMMENT="Horários de funcionamento"');

        // 7. Tabela de Agendamentos
        $this->createTable('{{%agendamento}}', [
            'id' => $this->primaryKey(),
            'cliente_id' => $this->integer()->notNull()->comment('ID do cliente'),
            'funcionario_id' => $this->integer()->notNull()->comment('ID do funcionário'),
            'servico_id' => $this->integer()->notNull()->comment('ID do serviço'),
            'empresa_id' => $this->integer()->notNull()->comment('ID da empresa'),
            'data_agendamento' => $this->dateTime()->notNull()->comment('Data e hora do agendamento'),
            'status' => $this->string(20)->defaultValue('pendente')->comment('pendente, confirmado, cancelado, concluido'),
            'observacoes' => $this->text()->comment('Observações do agendamento'),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ], 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB COMMENT="Agendamentos realizados"');

        // ===== ÍNDICES E CHAVES ESTRANGEIRAS =====

        // Índices para melhorar performance
        $this->createIndex('idx_empresa_email', '{{%empresa}}', 'email');
        $this->createIndex('idx_empresa_status', '{{%empresa}}', 'status');
        
        $this->createIndex('idx_usuario_role', '{{%usuario}}', 'role');
        $this->createIndex('idx_usuario_empresa', '{{%usuario}}', 'empresa_id');
        $this->createIndex('idx_usuario_status', '{{%usuario}}', 'status');
        
        $this->createIndex('idx_funcionario_empresa', '{{%funcionario}}', 'empresa_id');
        $this->createIndex('idx_servico_empresa', '{{%servico}}', 'empresa_id');
        $this->createIndex('idx_cliente_empresa', '{{%cliente}}', 'empresa_id');
        $this->createIndex('idx_cliente_email', '{{%cliente}}', ['empresa_id', 'email']);
        
        $this->createIndex('idx_horario_empresa', '{{%horario}}', 'empresa_id');
        $this->createIndex('idx_horario_funcionario', '{{%horario}}', 'funcionario_id');
        $this->createIndex('idx_horario_dia', '{{%horario}}', ['empresa_id', 'dia_semana']);
        
        $this->createIndex('idx_agendamento_empresa', '{{%agendamento}}', 'empresa_id');
        $this->createIndex('idx_agendamento_cliente', '{{%agendamento}}', 'cliente_id');
        $this->createIndex('idx_agendamento_funcionario', '{{%agendamento}}', 'funcionario_id');
        $this->createIndex('idx_agendamento_data', '{{%agendamento}}', 'data_agendamento');
        $this->createIndex('idx_agendamento_status', '{{%agendamento}}', 'status');

        // Chaves estrangeiras
        $this->addForeignKey(
            'fk_usuario_empresa',
            '{{%usuario}}',
            'empresa_id',
            '{{%empresa}}',
            'id',
            'SET NULL',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_funcionario_empresa',
            '{{%funcionario}}',
            'empresa_id',
            '{{%empresa}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_servico_empresa',
            '{{%servico}}',
            'empresa_id',
            '{{%empresa}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_cliente_empresa',
            '{{%cliente}}',
            'empresa_id',
            '{{%empresa}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_horario_empresa',
            '{{%horario}}',
            'empresa_id',
            '{{%empresa}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_horario_funcionario',
            '{{%horario}}',
            'funcionario_id',
            '{{%funcionario}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_agendamento_cliente',
            '{{%agendamento}}',
            'cliente_id',
            '{{%cliente}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_agendamento_funcionario',
            '{{%agendamento}}',
            'funcionario_id',
            '{{%funcionario}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_agendamento_servico',
            '{{%agendamento}}',
            'servico_id',
            '{{%servico}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_agendamento_empresa',
            '{{%agendamento}}',
            'empresa_id',
            '{{%empresa}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        // ===== DADOS INICIAIS =====

        // Criar usuário admin geral
        $this->insert('{{%usuario}}', [
            'username' => 'admin',
            'nome_completo' => 'Administrador do Sistema',
            'email' => 'admin@sistema.com',
            'password_hash' => '$2y$13$HASH_EXAMPLE', // Altere para hash real
            'auth_key' => 'AUTH_KEY_EXAMPLE', // Altere para auth key real
            'role' => 'admin',
            'empresa_id' => null,
            'status' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        echo "Sistema completo de agendamentos criado com sucesso!\n";
        echo "- 7 tabelas principais criadas\n";
        echo "- Índices de performance adicionados\n";
        echo "- Chaves estrangeiras configuradas com CASCADE\n";
        echo "- Usuário admin inicial criado\n";
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Remover chaves estrangeiras primeiro
        $this->dropForeignKey('fk_agendamento_empresa', '{{%agendamento}}');
        $this->dropForeignKey('fk_agendamento_servico', '{{%agendamento}}');
        $this->dropForeignKey('fk_agendamento_funcionario', '{{%agendamento}}');
        $this->dropForeignKey('fk_agendamento_cliente', '{{%agendamento}}');
        $this->dropForeignKey('fk_horario_funcionario', '{{%horario}}');
        $this->dropForeignKey('fk_horario_empresa', '{{%horario}}');
        $this->dropForeignKey('fk_cliente_empresa', '{{%cliente}}');
        $this->dropForeignKey('fk_servico_empresa', '{{%servico}}');
        $this->dropForeignKey('fk_funcionario_empresa', '{{%funcionario}}');
        $this->dropForeignKey('fk_usuario_empresa', '{{%usuario}}');

        // Remover tabelas em ordem reversa
        $this->dropTable('{{%agendamento}}');
        $this->dropTable('{{%horario}}');
        $this->dropTable('{{%cliente}}');
        $this->dropTable('{{%servico}}');
        $this->dropTable('{{%funcionario}}');
        $this->dropTable('{{%usuario}}');
        $this->dropTable('{{%empresa}}');

        echo "Sistema removido com sucesso!\n";
    }
}