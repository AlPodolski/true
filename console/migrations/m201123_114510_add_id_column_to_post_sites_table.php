<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%post_sites}}`.
 */
class m201123_114510_add_id_column_to_post_sites_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('post_sites', 'id', $this->primaryKey());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('post_sites', 'id');
    }
}
