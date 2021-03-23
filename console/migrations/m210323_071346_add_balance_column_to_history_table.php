<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%history}}`.
 */
class m210323_071346_add_balance_column_to_history_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('history', 'balance', $this->smallInteger()->unsigned());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('history', 'balance');
    }
}
