<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%review_items}}`.
 */
class m201105_124030_create_review_items_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%review_marcs}}', [
            'id' => $this->primaryKey(),
            'review_id' => $this->tinyInteger(),
            'post_id' => $this->integer(),
            'marc' => $this->tinyInteger(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%review_items}}');
    }
}
