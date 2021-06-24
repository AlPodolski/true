<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%request_call}}`.
 */
class m210624_095120_create_request_call_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%request_call}}', [
            'id' => $this->primaryKey(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'post_id' => $this->integer(),
            'user_id' => $this->integer(),
            'text' => $this->string(),
            'phone' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%request_call}}');
    }
}
