<?php

use yii\db\Migration;

/**
 * Class m251201_000004_create_employee_schedule
 */
class m251201_000004_create_employee_schedule extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%employee_schedule}}', [
            'id' => $this->primaryKey(),
            'employee_id' => $this->integer()->notNull(),
            'day_of_week' => $this->smallInteger()->notNull(), // 0=domingo, 1=segunda, ..., 6=sábado
            'start_time' => $this->time()->notNull(),
            'end_time' => $this->time()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex('idx-employee_schedule-employee_id', '{{%employee_schedule}}', 'employee_id');
        $this->addForeignKey(
            'fk-employee_schedule-employee',
            '{{%employee_schedule}}',
            'employee_id',
            '{{%employee}}',
            'id',
            'CASCADE',
            'RESTRICT'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-employee_schedule-employee', '{{%employee_schedule}}');
        $this->dropTable('{{%employee_schedule}}');
    }
}
