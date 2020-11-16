<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%service_reviews}}`.
 */
class m201106_085504_create_service_reviews_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%service_reviews}}', [
            'id' => $this->primaryKey(),
            'post_id' => $this->integer(),
            'service_id' => $this->smallInteger(),
            'marc' => $this->tinyInteger(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%service_reviews}}');
    }
}
