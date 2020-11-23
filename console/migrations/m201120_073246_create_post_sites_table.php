<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%post_sites}}`.
 */
class m201120_073246_create_post_sites_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%post_sites}}', [
            'post_id' => $this->integer(),
            'site_id' => $this->integer(),
            'price' => $this->smallInteger()->unsigned(),
            'created_at' => $this->integer()->unsigned()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%post_sites}}');
    }
}
