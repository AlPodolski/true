<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%chat}}`.
 */
class m210305_084403_create_chat_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%chat}}', [
            'id' => $this->primaryKey(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%chat}}');
    }
}
