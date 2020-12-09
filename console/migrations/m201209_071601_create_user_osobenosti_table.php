<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_osobenosti}}`.
 */
class m201209_071601_create_user_osobenosti_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_osobenosti}}', [
            'post_id' => $this->integer(),
            'param_id' => $this->tinyInteger(),
            'city_id' => $this->tinyInteger(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_osobenosti}}');
    }
}
