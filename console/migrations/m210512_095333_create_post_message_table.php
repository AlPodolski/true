<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%post_message}}`.
 */
class m210512_095333_create_post_message_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%post_message}}', [
            'id' => $this->primaryKey(),
            'post_id' => $this->integer(),
            'status' => $this->tinyInteger(1)->unsigned()->defaultValue(0),
            'message' => $this->text(),
        ]);

        $this->addForeignKey('fk-post-message_id-post-id', 'post_message', 'post_id',
            'posts', 'id', 'CASCADE', 'CASCADE');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%post_message}}');
    }
}
