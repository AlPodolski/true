<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%review}}`.
 */
class m201117_121501_add_author_column_to_review_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('review', 'author', $this->integer()->after('post_id'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('review', 'author');
    }
}
