<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%review}}`.
 */
class m210427_130719_add_is_validate_column_to_review_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('review', 'is_moderate', $this->tinyInteger(1)->unsigned()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('review', 'is_moderate');
    }
}
