<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%telegram_token}}`.
 */
class m210603_061916_create_telegram_token_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%telegram_token}}', [
            'id' => $this->primaryKey(),
            'token' => $this->string()->unique()->notNull(),
            'telegram_user_id' => $this->integer()->unsigned()->notNull(),
            'telegram_chat_id' => $this->integer()->unsigned()->notNull(),
            'token_status' => $this->tinyInteger(1)
                ->defaultValue(0)->comment('статус токе 0 - токен выпущен но не подтвержден 1 токен подтвержден'),
            'created_at' => $this->integer()->unsigned(),
            'updated_at' => $this->integer()->unsigned(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%telegram_token}}');
    }
}
