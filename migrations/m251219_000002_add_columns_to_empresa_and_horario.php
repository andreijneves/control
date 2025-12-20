<?php

use yii\db\Migration;

class m251219_000002_add_columns_to_empresa_and_horario extends Migration
{
    public function safeUp()
    {
        // Adicionar colunas à tabela empresa
        $this->addColumn('{{%empresa}}', 'descricao', $this->text()->after('endereco'));
        $this->addColumn('{{%empresa}}', 'cidade', $this->string(100)->after('descricao'));

        // Adicionar colunas à tabela horario para empresa
        $this->addColumn('{{%horario}}', 'empresa_id', $this->integer()->after('funcionario_id'));
        $this->addColumn('{{%horario}}', 'dia_semana_texto', $this->string(20)->after('dia_semana'));

        // Se necessário, adicionar foreign key para empresa_id na tabela horario
        $this->addForeignKey(
            'fk_horario_empresa',
            '{{%horario}}',
            'empresa_id',
            '{{%empresa}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_horario_empresa', '{{%horario}}');
        $this->dropColumn('{{%horario}}', 'dia_semana_texto');
        $this->dropColumn('{{%horario}}', 'empresa_id');
        $this->dropColumn('{{%empresa}}', 'cidade');
        $this->dropColumn('{{%empresa}}', 'descricao');
    }
}
