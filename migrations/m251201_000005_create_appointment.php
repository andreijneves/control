<?php

use yii\db\Migration;

/**
 * Class m251201_000005_create_appointment
 */
class m251201_000005_create_appointment extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%appointment}}', [
            'id' => $this->primaryKey(),
            'barbershop_id' => $this->integer()->notNull(),
            'service_id' => $this->integer()->notNull(),
            'employee_id' => $this->integer()->notNull(),
            'client_name' => $this->string(120)->notNull(),
            'client_email' => $this->string(180)->null(),
            'client_phone' => $this->string(32)->null(),
            'appointment_date' => $this->date()->notNull(),
            'appointment_time' => $this->time()->notNull(),
            'status' => $this->string(32)->notNull()->defaultValue('pending'), // pending, confirmed, cancelled, completed
            'notes' => $this->text()->null(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex('idx-appointment-barbershop_id', '{{%appointment}}', 'barbershop_id');
        $this->createIndex('idx-appointment-service_id', '{{%appointment}}', 'service_id');
        $this->createIndex('idx-appointment-employee_id', '{{%appointment}}', 'employee_id');
        $this->createIndex('idx-appointment-date', '{{%appointment}}', 'appointment_date');
        
        $this->addForeignKey('fk-appointment-barbershop', '{{%appointment}}', 'barbershop_id', '{{%barbershop}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('fk-appointment-service', '{{%appointment}}', 'service_id', '{{%service}}', 'id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('fk-appointment-employee', '{{%appointment}}', 'employee_id', '{{%employee}}', 'id', 'RESTRICT', 'RESTRICT');
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-appointment-employee', '{{%appointment}}');
        $this->dropForeignKey('fk-appointment-service', '{{%appointment}}');
        $this->dropForeignKey('fk-appointment-barbershop', '{{%appointment}}');
        $this->dropTable('{{%appointment}}');
    }
}
