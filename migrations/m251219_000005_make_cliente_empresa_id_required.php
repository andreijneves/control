<?php

use yii\db\Migration;

/**
 * Migration para tornar o campo empresa_id obrigatório novamente na tabela cliente
 * pois cada cliente pertence diretamente a apenas uma empresa
 */
class m251219_000005_make_cliente_empresa_id_required extends Migration
{
    public function safeUp()
    {
        // Remover registros que têm empresa_id null antes de aplicar a constraint NOT NULL
        $this->delete('{{%cliente}}', ['empresa_id' => null]);
        
        // Remover a foreign key existente
        $this->dropForeignKey('fk_cliente_empresa', '{{%cliente}}');
        
        // Modificar a coluna para NOT NULL
        $this->alterColumn('{{%cliente}}', 'empresa_id', $this->integer()->notNull());
        
        // Recriar a foreign key
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

    public function safeDown()
    {
        // Remover a foreign key
        $this->dropForeignKey('fk_cliente_empresa', '{{%cliente}}');
        
        // Voltar a coluna para nullable
        $this->alterColumn('{{%cliente}}', 'empresa_id', $this->integer());
        
        // Recriar a foreign key com SET NULL
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
}