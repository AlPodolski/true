<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%city_block}}`.
 */
class m231116_115029_create_city_block_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%city_block}}', [
            'id' => $this->primaryKey(),
            'city_id' => $this->integer(),
            'old_city' => $this->string(),
            'new_city' => $this->string(),
            'created_at' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%city_block}}');
    }
}
