<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%history}}`.
 */
class m210817_082238_add_post_id_column_to_history_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('history', 'post_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('history', 'post_id');
    }
}
