<?php

use yii\db\Migration;

class m251215_000002_create_organization_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%organization}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'cnpj' => $this->string(18)->unique(),
            'email' => $this->string(255),
            'phone' => $this->string(20),
            'address' => $this->text(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        $this->createIndex('idx_organization_name', '{{%organization}}', 'name');
        $this->createIndex('idx_organization_cnpj', '{{%organization}}', 'cnpj', true);
        $this->createIndex('idx_organization_status', '{{%organization}}', 'status');
    }

    public function safeDown()
    {
        $this->dropTable('{{%organization}}');
    }
}
