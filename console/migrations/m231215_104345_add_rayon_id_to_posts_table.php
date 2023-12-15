<?php

use yii\db\Migration;

/**
 * Class m231215_104345_add_rayon_id_to_posts_table
 */
class m231215_104345_add_rayon_id_to_posts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('posts', 'rayon_id', $this->smallInteger()->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('posts', 'rayon_id');
    }

}
