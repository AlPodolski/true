<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%review_items}}`.
 */
class m201105_122233_create_review_items_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%review_items}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50),
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
