<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%event}}`.
 */
class m210517_133018_create_event_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%event}}', [
            'id' => $this->primaryKey(),
            'post_id' => $this->integer(),
            'user_id' => $this->integer(),
            'type' => $this->tinyInteger(1)->defaultValue(0),
            'status' => $this->tinyInteger(1)->defaultValue(0),
        ]);

        $this->addForeignKey('fk-even_id-post-id', 'event', 'post_id',
            'posts', 'id', 'CASCADE', 'CASCADE');

        $this->addForeignKey('fk-even_id-user-id', 'event', 'user_id',
            'user', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%event}}');
    }
}
