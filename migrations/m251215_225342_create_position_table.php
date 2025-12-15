<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%position}}`.
 */
class m251215_225342_create_position_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%position}}', [
            'id' => $this->primaryKey(),
            'organization_id' => $this->integer()->notNull(),
            'name' => $this->string(255)->notNull(),
            'description' => $this->text(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        $this->createIndex('idx_position_organization', '{{%position}}', 'organization_id');
        $this->createIndex('idx_position_status', '{{%position}}', 'status');
        
        $this->addForeignKey(
            'fk_position_organization',
            '{{%position}}',
            'organization_id',
            '{{%organization}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_position_organization', '{{%position}}');
        $this->dropTable('{{%position}}');
    }
}
