<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%phone_review}}`.
 */
class m210823_070809_add_created_at_column_to_phone_review_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('phone_review', 'created_at', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('phone_review', 'created_at');
    }
}
