<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_service}}`.
 */
class m201118_075152_create_user_service_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_service}}', [
            'post_id' => $this->integer(),
            'service_id' => $this->tinyInteger()->unsigned(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_service}}');
    }
}
