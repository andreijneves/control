<?php

use yii\db\Migration;

/**
 * Migration para tornar o campo funcionario_id nullable na tabela horario
 * para permitir horários da empresa sem funcionário específico
 */
class m251219_000003_fix_horario_funcionario_id_nullable extends Migration
{
    public function safeUp()
    {
        // Primeiro remover a foreign key existente
        $this->dropForeignKey('fk_horario_funcionario', '{{%horario}}');
        
        // Modificar a coluna para ser nullable
        $this->alterColumn('{{%horario}}', 'funcionario_id', $this->integer());
        
        // Recriar a foreign key com DELETE SET NULL
        $this->addForeignKey(
            'fk_horario_funcionario',
            '{{%horario}}',
            'funcionario_id',
            '{{%funcionario}}',
            'id',
            'SET NULL',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        // Remover registros que têm funcionario_id null antes de recriar a constraint NOT NULL
        $this->delete('{{%horario}}', ['funcionario_id' => null]);
        
        // Remover a foreign key
        $this->dropForeignKey('fk_horario_funcionario', '{{%horario}}');
        
        // Voltar a coluna para NOT NULL
        $this->alterColumn('{{%horario}}', 'funcionario_id', $this->integer()->notNull());
        
        // Recriar a foreign key original
        $this->addForeignKey(
            'fk_horario_funcionario',
            '{{%horario}}',
            'funcionario_id',
            '{{%funcionario}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }
}