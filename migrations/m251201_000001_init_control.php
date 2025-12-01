<?php

use yii\db\Migration;

/**
 * Class m251201_000001_init_control
 */
class m251201_000001_init_control extends Migration
{
    public function safeUp()
    {
        // barbershop
        $this->createTable('{{%barbershop}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(120)->notNull(),
            'email' => $this->string(180)->notNull()->unique(),
            'phone' => $this->string(32)->null(),
            'address' => $this->string(255)->null(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        // account (users of barbershop)
        $this->createTable('{{%account}}', [
            'id' => $this->primaryKey(),
            'barbershop_id' => $this->integer()->notNull(),
            'username' => $this->string(64)->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string(180)->notNull()->unique(),
            'role' => $this->string(32)->notNull()->defaultValue('admin'), // admin|staff
            'status' => $this->smallInteger()->notNull()->defaultValue(10), // 10=active, 0=inactive
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
        $this->createIndex('idx-account-barbershop_id', '{{%account}}', 'barbershop_id');
        $this->addForeignKey('fk-account-barbershop', '{{%account}}', 'barbershop_id', '{{%barbershop}}', 'id', 'CASCADE', 'RESTRICT');

        // employee
        $this->createTable('{{%employee}}', [
            'id' => $this->primaryKey(),
            'barbershop_id' => $this->integer()->notNull(),
            'name' => $this->string(120)->notNull(),
            'email' => $this->string(180)->null(),
            'phone' => $this->string(32)->null(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
        $this->createIndex('idx-employee-barbershop_id', '{{%employee}}', 'barbershop_id');
        $this->addForeignKey('fk-employee-barbershop', '{{%employee}}', 'barbershop_id', '{{%barbershop}}', 'id', 'CASCADE', 'RESTRICT');

        // service
        $this->createTable('{{%service}}', [
            'id' => $this->primaryKey(),
            'barbershop_id' => $this->integer()->notNull(),
            'name' => $this->string(120)->notNull(),
            'description' => $this->text()->null(),
            'duration_min' => $this->integer()->notNull()->defaultValue(30),
            'price' => $this->decimal(10,2)->notNull()->defaultValue(0),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
        $this->createIndex('idx-service-barbershop_id', '{{%service}}', 'barbershop_id');
        $this->addForeignKey('fk-service-barbershop', '{{%service}}', 'barbershop_id', '{{%barbershop}}', 'id', 'CASCADE', 'RESTRICT');
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-service-barbershop', '{{%service}}');
        $this->dropTable('{{%service}}');

        $this->dropForeignKey('fk-employee-barbershop', '{{%employee}}');
        $this->dropTable('{{%employee}}');

        $this->dropForeignKey('fk-account-barbershop', '{{%account}}');
        $this->dropTable('{{%account}}');

        $this->dropTable('{{%barbershop}}');
    }
}
