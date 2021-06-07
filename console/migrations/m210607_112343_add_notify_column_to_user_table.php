<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%user}}`.
 */
class m210607_112343_add_notify_column_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user',
            'notify',
            $this->tinyInteger()
            ->defaultValue(1)->comment('1 отправка уведомлений резрешена 0 запрещена')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user', 'notify');
    }
}
