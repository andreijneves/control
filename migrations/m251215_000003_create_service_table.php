<?php

use yii\db\Migration;

class m251215_000003_create_service_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%service}}', [
            'id' => $this->primaryKey(),
            'organization_id' => $this->integer()->notNull(),
            'name' => $this->string(255)->notNull(),
            'description' => $this->text(),
            'price' => $this->decimal(10, 2),
            'duration' => $this->integer()->comment('Duração em minutos'),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        $this->createIndex('idx_service_organization_id', '{{%service}}', 'organization_id');
        $this->createIndex('idx_service_name', '{{%service}}', 'name');
        $this->createIndex('idx_service_status', '{{%service}}', 'status');

        $this->addForeignKey(
            'fk_service_organization',
            '{{%service}}',
            'organization_id',
            '{{%organization}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_service_organization', '{{%service}}');
        $this->dropTable('{{%service}}');
    }
}
