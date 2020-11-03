<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%posts}}`.
 */
class m201103_110925_add_price_column_to_posts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('posts', 'price', $this->integer(5)->unsigned());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('posts', 'price');
    }
}
