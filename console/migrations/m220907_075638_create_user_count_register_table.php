<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_count_register}}`.
 */
class m220907_075638_create_user_count_register_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_count_register}}', [
            'id' => $this->primaryKey(),
            'date' => $this->string(),
            'count' => $this->smallInteger()->unsigned()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_count_register}}');
    }
}
