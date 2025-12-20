<?php

use yii\db\Migration;

/**
 * Migration para tornar o campo empresa_id nullable na tabela cliente
 * para permitir clientes gerais não vinculados a empresa específica
 */
class m251219_000004_fix_cliente_empresa_id_nullable extends Migration
{
    public function safeUp()
    {
        // Primeiro remover a foreign key existente
        $this->dropForeignKey('fk_cliente_empresa', '{{%cliente}}');
        
        // Modificar a coluna para ser nullable
        $this->alterColumn('{{%cliente}}', 'empresa_id', $this->integer());
        
        // Recriar a foreign key com DELETE SET NULL
        $this->addForeignKey(
            'fk_cliente_empresa',
            '{{%cliente}}',
            'empresa_id',
            '{{%empresa}}',
            'id',
            'SET NULL',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        // Remover registros que têm empresa_id null antes de recriar a constraint NOT NULL
        $this->delete('{{%cliente}}', ['empresa_id' => null]);
        
        // Remover a foreign key
        $this->dropForeignKey('fk_cliente_empresa', '{{%cliente}}');
        
        // Voltar a coluna para NOT NULL
        $this->alterColumn('{{%cliente}}', 'empresa_id', $this->integer()->notNull());
        
        // Recriar a foreign key original
        $this->addForeignKey(
            'fk_cliente_empresa',
            '{{%cliente}}',
            'empresa_id',
            '{{%empresa}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }
}