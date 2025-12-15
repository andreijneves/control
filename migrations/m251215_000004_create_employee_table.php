<?php

use yii\db\Migration;

class m251215_000004_create_employee_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%employee}}', [
            'id' => $this->primaryKey(),
            'organization_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->unique(),
            'name' => $this->string(255)->notNull(),
            'cpf' => $this->string(14)->unique(),
            'email' => $this->string(255)->notNull(),
            'phone' => $this->string(20),
            'position' => $this->string(100)->comment('Cargo'),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        $this->createIndex('idx_employee_organization_id', '{{%employee}}', 'organization_id');
        $this->createIndex('idx_employee_user_id', '{{%employee}}', 'user_id', true);
        $this->createIndex('idx_employee_email', '{{%employee}}', 'email');
        $this->createIndex('idx_employee_cpf', '{{%employee}}', 'cpf', true);
        $this->createIndex('idx_employee_status', '{{%employee}}', 'status');

        $this->addForeignKey(
            'fk_employee_organization',
            '{{%employee}}',
            'organization_id',
            '{{%organization}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_employee_user',
            '{{%employee}}',
            'user_id',
            '{{%user}}',
            'id',
            'SET NULL',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_employee_user', '{{%employee}}');
        $this->dropForeignKey('fk_employee_organization', '{{%employee}}');
        $this->dropTable('{{%employee}}');
    }
}
