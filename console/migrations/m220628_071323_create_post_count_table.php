<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%post_count}}`.
 */
class m220628_071323_create_post_count_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%post_count}}', [
            'id' => $this->primaryKey(),
            'date' => $this->string(),
            'count' => $this->smallInteger()->unsigned()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%post_count}}');
    }
}
