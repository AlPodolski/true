<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%post_message}}`.
 */
class m210513_065749_add_created_at_and_updated_at_columns_to_post_message_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('post_message', 'created_at', $this->integer());
        $this->addColumn('post_message', 'updated_at', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('post_message', 'created_at');
        $this->dropColumn('post_message', 'updated_at');
    }
}
