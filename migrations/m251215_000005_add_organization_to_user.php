<?php

use yii\db\Migration;

class m251215_000005_add_organization_to_user extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'organization_id', $this->integer()->after('role'));
        $this->createIndex('idx_user_organization_id', '{{%user}}', 'organization_id');

        $this->addForeignKey(
            'fk_user_organization',
            '{{%user}}',
            'organization_id',
            '{{%organization}}',
            'id',
            'SET NULL',
            'CASCADE'
        );

        // Atualiza a coluna role para aceitar o novo perfil
        $this->alterColumn('{{%user}}', 'role', $this->string(32)->notNull()->defaultValue('usuario'));
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_user_organization', '{{%user}}');
        $this->dropIndex('idx_user_organization_id', '{{%user}}');
        $this->dropColumn('{{%user}}', 'organization_id');
    }
}
