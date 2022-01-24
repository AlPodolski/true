<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_time}}`.
 */
class m220124_080150_create_user_time_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_time}}', [
            'id' => $this->primaryKey(),
            'param_id' => $this->integer(),
            'post_id' => $this->integer(),
            'city_id' => $this->smallInteger(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_time}}');
    }
}
