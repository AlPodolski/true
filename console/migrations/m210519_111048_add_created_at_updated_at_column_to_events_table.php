<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%events}}`.
 */
class m210519_111048_add_created_at_updated_at_column_to_events_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('event', 'created_at', $this->integer()->unsigned());
        $this->addColumn('event', 'updated_at', $this->integer()->unsigned());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('event', 'created_at');
        $this->dropColumn('event', 'updated_at');
    }
}
