<?php

use yii\db\Migration;

/**
 * Class m231214_143806_add_intim_hair_color_id_to_posts
 */
class m231214_143806_add_intim_hair_color_id_to_posts extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('posts', 'intim_hair_id', $this->tinyInteger()->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('posts', 'intim_hair_id');
    }

}
