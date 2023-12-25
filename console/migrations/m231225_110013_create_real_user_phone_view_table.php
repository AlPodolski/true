<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%real_user_phone_view}}`.
 */
class m231225_110013_create_real_user_phone_view_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%real_user_phone_view}}', [
            'id' => $this->primaryKey(),
            'date' => $this->string(),
            'count' => $this->smallInteger(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%real_user_phone_view}}');
    }
}
