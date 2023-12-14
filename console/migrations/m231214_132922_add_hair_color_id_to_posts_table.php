<?php

use yii\db\Migration;

/**
 * Class m231214_132922_add_hair_color_id_to_posts_table
 */
class m231214_132922_add_hair_color_id_to_posts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('posts', 'hair_color_id', $this->tinyInteger()->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('posts', 'hair_color_id');
    }

}
