<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_metro}}`.
 */
class m201103_115229_create_user_metro_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_metro}}', [
            'id' => $this->primaryKey(),
            'post_id' => $this->integer(),
            'metro_id' => $this->smallInteger(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_metro}}');
    }
}
