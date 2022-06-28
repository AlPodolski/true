<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%cash_count}}`.
 */
class m220627_114641_create_cash_count_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%cash_count}}', [
            'id' => $this->primaryKey(),
            'date' => $this->string(),
            'count' => $this->smallInteger()->unsigned()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%cash_count}}');
    }
}
