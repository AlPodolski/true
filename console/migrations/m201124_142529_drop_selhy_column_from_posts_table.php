<?php

use yii\db\Migration;

/**
 * Handles dropping columns from table `{{%posts}}`.
 */
class m201124_142529_drop_selhy_column_from_posts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('posts', 'selfie');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('posts', 'selfie', $this->tinyInteger());
    }
}
