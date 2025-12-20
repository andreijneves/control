<?php

use yii\db\Migration;

class m251219_000001_create_initial_tables extends Migration
{
    public function safeUp()
    {
        // Tabela empresa
        $this->createTable('{{%empresa}}', [
            'id' => $this->primaryKey(),
            'nome' => $this->string(255)->notNull(),
            'cnpj' => $this->string(18)->unique(),
            'email' => $this->string(255),
            'telefone' => $this->string(20),
            'endereco' => $this->text(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        // Tabela usuario
        $this->createTable('{{%usuario}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(255)->notNull()->unique(),
            'password_hash' => $this->string(255)->notNull(),
            'auth_key' => $this->string(32)->notNull(),
            'access_token' => $this->string(255),
            'role' => $this->string(50)->notNull()->defaultValue('cliente'), // admin_geral, admin_empresa, funcionario, cliente
            'empresa_id' => $this->integer(),
            'nome_completo' => $this->string(255),
            'email' => $this->string(255),
            'telefone' => $this->string(20),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        $this->addForeignKey(
            'fk_usuario_empresa',
            '{{%usuario}}',
            'empresa_id',
            '{{%empresa}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        // Tabela funcionario
        $this->createTable('{{%funcionario}}', [
            'id' => $this->primaryKey(),
            'usuario_id' => $this->integer()->notNull(),
            'empresa_id' => $this->integer()->notNull(),
            'nome' => $this->string(255)->notNull(),
            'cpf' => $this->string(14),
            'email' => $this->string(255),
            'telefone' => $this->string(20),
            'cargo' => $this->string(100),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        $this->addForeignKey(
            'fk_funcionario_usuario',
            '{{%funcionario}}',
            'usuario_id',
            '{{%usuario}}',
            'id',
            'CASCADE',
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

        // Tabela servico
        $this->createTable('{{%servico}}', [
            'id' => $this->primaryKey(),
            'empresa_id' => $this->integer()->notNull(),
            'nome' => $this->string(255)->notNull(),
            'descricao' => $this->text(),
            'preco' => $this->decimal(10, 2)->notNull(),
            'duracao_minutos' => $this->integer(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        $this->addForeignKey(
            'fk_servico_empresa',
            '{{%servico}}',
            'empresa_id',
            '{{%empresa}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        // Tabela cliente
        $this->createTable('{{%cliente}}', [
            'id' => $this->primaryKey(),
            'empresa_id' => $this->integer()->notNull(),
            'usuario_id' => $this->integer(),
            'nome' => $this->string(255)->notNull(),
            'cpf' => $this->string(14),
            'email' => $this->string(255),
            'telefone' => $this->string(20),
            'endereco' => $this->text(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);

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
            'fk_cliente_usuario',
            '{{%cliente}}',
            'usuario_id',
            '{{%usuario}}',
            'id',
            'SET NULL',
            'CASCADE'
        );

        // Tabela horario (disponibilidade do funcionário)
        $this->createTable('{{%horario}}', [
            'id' => $this->primaryKey(),
            'funcionario_id' => $this->integer()->notNull(),
            'dia_semana' => $this->integer()->notNull(), // 0-6 (domingo-sábado)
            'hora_inicio' => $this->time(),
            'hora_fim' => $this->time(),
            'disponivel' => $this->boolean()->notNull()->defaultValue(true),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        $this->addForeignKey(
            'fk_horario_funcionario',
            '{{%horario}}',
            'funcionario_id',
            '{{%funcionario}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        // Tabela agendamento
        $this->createTable('{{%agendamento}}', [
            'id' => $this->primaryKey(),
            'cliente_id' => $this->integer()->notNull(),
            'funcionario_id' => $this->integer()->notNull(),
            'servico_id' => $this->integer()->notNull(),
            'empresa_id' => $this->integer()->notNull(),
            'data_agendamento' => $this->datetime()->notNull(),
            'status' => $this->string(20)->notNull()->defaultValue('pendente'), // pendente, confirmado, cancelado, concluido
            'observacoes' => $this->text(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);

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

        // Criar índices para melhor performance
        $this->createIndex('idx_usuario_role', '{{%usuario}}', 'role');
        $this->createIndex('idx_usuario_empresa_id', '{{%usuario}}', 'empresa_id');
        $this->createIndex('idx_funcionario_empresa_id', '{{%funcionario}}', 'empresa_id');
        $this->createIndex('idx_servico_empresa_id', '{{%servico}}', 'empresa_id');
        $this->createIndex('idx_cliente_empresa_id', '{{%cliente}}', 'empresa_id');
        $this->createIndex('idx_agendamento_cliente_id', '{{%agendamento}}', 'cliente_id');
        $this->createIndex('idx_agendamento_funcionario_id', '{{%agendamento}}', 'funcionario_id');
        $this->createIndex('idx_agendamento_servico_id', '{{%agendamento}}', 'servico_id');
        $this->createIndex('idx_agendamento_empresa_id', '{{%agendamento}}', 'empresa_id');
    }

    public function safeDown()
    {
        // Remover chaves estrangeiras
        $this->dropForeignKey('fk_agendamento_empresa', '{{%agendamento}}');
        $this->dropForeignKey('fk_agendamento_servico', '{{%agendamento}}');
        $this->dropForeignKey('fk_agendamento_funcionario', '{{%agendamento}}');
        $this->dropForeignKey('fk_agendamento_cliente', '{{%agendamento}}');
        $this->dropForeignKey('fk_horario_funcionario', '{{%horario}}');
        $this->dropForeignKey('fk_cliente_usuario', '{{%cliente}}');
        $this->dropForeignKey('fk_cliente_empresa', '{{%cliente}}');
        $this->dropForeignKey('fk_servico_empresa', '{{%servico}}');
        $this->dropForeignKey('fk_funcionario_empresa', '{{%funcionario}}');
        $this->dropForeignKey('fk_funcionario_usuario', '{{%funcionario}}');
        $this->dropForeignKey('fk_usuario_empresa', '{{%usuario}}');

        // Remover tabelas
        $this->dropTable('{{%agendamento}}');
        $this->dropTable('{{%horario}}');
        $this->dropTable('{{%cliente}}');
        $this->dropTable('{{%servico}}');
        $this->dropTable('{{%funcionario}}');
        $this->dropTable('{{%usuario}}');
        $this->dropTable('{{%empresa}}');
    }
}
