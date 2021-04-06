<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%top_anket_block}}`.
 */
class m210406_065326_create_top_anket_block_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%top_anket_block}}', [
            'post_id' => $this->integer()->unsigned(),
            'city_id' => $this->smallInteger(),
            'valid_to' => $this->integer()->unsigned(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%top_anket_block}}');
    }
}
