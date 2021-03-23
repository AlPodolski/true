<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%hystory}}`.
 */
class m210322_134138_create_hystory_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%history}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->unsigned(),
            'sum' => $this->smallInteger()->unsigned(),
            'type' => $this->tinyInteger()->unsigned(),
            'created_at' => $this->integer()->unsigned(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%history}}');
    }
}
