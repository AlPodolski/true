<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%telegram_last_update}}`.
 */
class m210601_101622_create_telegram_last_update_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%telegram_last_update}}', [
            'id' => $this->primaryKey(),
            'update_id' => $this->integer()->unsigned()->comment('id последнего обновления в боте')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%telegram_last_update}}');
    }
}
