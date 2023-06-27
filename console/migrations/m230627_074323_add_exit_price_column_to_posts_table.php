<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%posts}}`.
 */
class m230627_074323_add_exit_price_column_to_posts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('posts', 'exit_hour_price', $this->smallInteger()->unsigned());
        $this->addColumn('posts', 'exit_two_hour_price', $this->smallInteger()->unsigned());
        $this->addColumn('posts', 'exit_night_price', $this->smallInteger()->unsigned());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('posts', 'exit_hour_price');
        $this->dropColumn('posts', 'exit_two_hour_price');
        $this->dropColumn('posts', 'exit_night_price');
    }
}
