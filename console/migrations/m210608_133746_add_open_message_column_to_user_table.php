<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%user}}`.
 */
class m210608_133746_add_open_message_column_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'open_message', $this->tinyInteger()
            ->defaultValue(1)
            ->comment('1 получение сообщений открыто 0 сообщения не принимаюсться')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user', 'open_message');
    }
}
