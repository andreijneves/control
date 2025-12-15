<?php

use yii\db\Migration;
use yii\db\Schema;

class m251215_000001_create_user_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(64)->notNull()->unique(),
            'password_hash' => $this->string()->notNull(),
            'auth_key' => $this->string(32)->notNull(),
            'access_token' => $this->string(128)->defaultValue(null),
            'role' => $this->string(32)->notNull()->defaultValue('usuario'),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => Schema::TYPE_DATETIME . ' NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'updated_at' => Schema::TYPE_DATETIME . ' NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
        ]);

        $this->createIndex('idx_user_username', '{{%user}}', 'username', true);
        $this->createIndex('idx_user_access_token', '{{%user}}', 'access_token', false);
        $this->createIndex('idx_user_role', '{{%user}}', 'role', false);

        $security = Yii::$app->getSecurity();
        $this->insert('{{%user}}', [
            'id' => 1,
            'username' => 'admin',
            'password_hash' => $security->generatePasswordHash('admin'),
            'auth_key' => $security->generateRandomString(),
            'access_token' => $security->generateRandomString(64),
            'role' => 'adm_geral',
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
