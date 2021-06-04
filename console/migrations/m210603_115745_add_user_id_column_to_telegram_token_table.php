<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%telegram_token}}`.
 */
class m210603_115745_add_user_id_column_to_telegram_token_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('telegram_token', 'user_id', $this->integer());

        $this->addForeignKey('fk-user_telegram_token_id', 'telegram_token', 'user_id',
            'user', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('telegram_token', 'user_id');
    }
}
