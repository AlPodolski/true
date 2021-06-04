<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_telegram}}`.
 */
class m210602_133910_create_user_telegram_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_telegram}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->comment('id пользователя на сайте'),
            'telegram_user_id' => $this->integer()->unsigned()->comment('id пользователя в телеграм'),
        ]);

        $this->addForeignKey('fk-user_telegram_user_id', 'user_telegram', 'user_id',
            'user', 'id', 'CASCADE', 'CASCADE');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_telegram}}');
    }
}
