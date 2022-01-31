<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%posts}}`.
 */
class m220131_105142_add_tarif_column_to_posts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('posts', 'tarif_id', $this->tinyInteger()->unsigned()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('posts', 'tarif_id');
    }
}
