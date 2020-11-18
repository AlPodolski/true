<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_place}}`.
 */
class m201118_064759_create_user_place_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_place}}', [
            'post_id' => $this->integer(),
            'place_id' => $this->tinyInteger(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_place}}');
    }
}
