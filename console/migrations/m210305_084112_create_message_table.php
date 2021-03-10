<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%message}}`.
 */
class m210305_084112_create_message_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%message}}', [
            'chat_id' => $this->integer()->unsigned(),
            'from' => $this->integer()->unsigned(),
            'to' => $this->integer()->unsigned(),
            'message' => $this->text(),
            'created_at' => $this->integer()->unsigned(),
            'status' => $this->smallInteger()->comment('Отражает состояние сообщения, прочитано или нет'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%message}}');
    }
}
