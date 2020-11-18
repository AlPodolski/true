<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%posts}}`.
 */
class m201118_074142_add_age_rost_ves_breast_columns_to_posts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('posts', 'age', $this->tinyInteger()->unsigned());
        $this->addColumn('posts', 'rost', $this->tinyInteger()->unsigned());
        $this->addColumn('posts', 'breast', $this->tinyInteger()->unsigned());
        $this->addColumn('posts', 'ves', $this->tinyInteger()->unsigned());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('posts', 'age');
        $this->dropColumn('posts', 'rost');
        $this->dropColumn('posts', 'breast');
        $this->dropColumn('posts', 'vest');
    }
}
