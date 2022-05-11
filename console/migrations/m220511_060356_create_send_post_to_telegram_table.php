<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%send_post_to_telegram}}`.
 */
class m220511_060356_create_send_post_to_telegram_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%send_post_to_telegram}}', [
            'id' => $this->primaryKey(),
            'post_id' => $this->integer()->unsigned(),
            'created_at' => $this->integer()->unsigned(),
            'job_id' => $this->integer()->unsigned(),
            'status' => $this->smallInteger()->unsigned()->defaultValue(0),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%send_post_to_telegram}}');
    }
}
