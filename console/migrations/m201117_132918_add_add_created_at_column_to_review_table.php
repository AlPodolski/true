<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%review}}`.
 */
class m201117_132918_add_add_created_at_column_to_review_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('review', 'created_at', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('review', 'created_at');
    }
}
