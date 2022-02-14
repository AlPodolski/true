<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%redirect}}`.
 */
class m220208_090616_create_redirect_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%redirect}}', [
            'id' => $this->primaryKey(),
            'from' => $this->string(),
            'to' => $this->string(),
            'user_agent' => $this->string(),
            'status' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%redirect}}');
    }
}
